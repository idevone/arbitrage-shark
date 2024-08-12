const tdl = require("tdl");
const { getTdjson } = require("prebuilt-tdlib");
const { findCards, cardVerification } = require("../utils/cardOperations");
require("dotenv").config();

const { API_ID, API_HASH, BOT_TOKEN, CHANNEL_ID } = process.env;

const validCards = [
  "4111111111111111",
  "5555555555554444",
  "378282246310005",
  "3J98t1WpEZ73CNmQviecrnyiWrnqRhWNLy",
];

const telegramClients = new Map();

tdl.configure({ tdjson: getTdjson() });

const botClient = tdl.createClient({
  apiId: API_ID,
  apiHash: API_HASH,
  databaseDirectory: "telegram_data/bot/_td_database",
  filesDirectory: "telegram_data/bot/_td_files",
});
botClient.loginAsBot(BOT_TOKEN);
botClient.on("error", (e) => console.error("Bot error", e));

function botSendMessage(text, user_id) {
  console.log("send with api bot:", text);
  botClient
    .invoke({
      _: "sendMessage",
      chat_id: user_id,
      disable_notification: false,
      from_background: true,
      input_message_content: {
        _: "inputMessageText",
        text: { text: text },
        disable_web_page_preview: false,
        clear_draft: false,
      },
    })
    .then((o) => {
      console.log("From then:", o);
    })
    .catch((e) => console.error(e));
}

function createTelegramClient(phoneNumber) {
  const findClient = telegramClients.get(phoneNumber);
  console.log("create");

  if (findClient) {
    return;
  }
  const client = tdl.createClient({
    apiId: API_ID,
    apiHash: API_HASH,
    databaseDirectory: `telegram_data/${phoneNumber}/_td_database`,
    filesDirectory: `telegram_data/${phoneNumber}/_td_files`,
  });

  telegramClients.set(phoneNumber, client);
}

async function clientPost(phoneNumber, object) {
  const client = telegramClients.get(phoneNumber);

  console.log("#######invoke", object);
  const res = await client.invoke(object);
  return res;
}

async function registerClient({ phoneNumber }) {
  const client = telegramClients.get(phoneNumber);
  const currentState = await client.invoke({ _: "getAuthorizationState" });
  console.log(currentState._);
  return currentState._;
}

async function startClient(phoneNumber) {
  const client = telegramClients.get(phoneNumber);
  await client.login({ type: "user" });

  const me = await client.invoke({ _: "getMe" });

  console.log(`I am ${me.first_name} ${me.last_name}`);

  client.on("error", console.error);

  client.on("update", (update) => {
    if (update._.includes("updateChatLastMessage")) {
      const {
        content = "",
        date = new Date().getTime(),
        sender_id = "",
      } = update?.last_message;
      const timestamp = date;
      const currentTime = Math.floor(Date.now() / 1000);

      if (currentTime - timestamp > 120) {
        return;
      }

      if (sender_id?.user_id !== me.id) {
        return;
      }
      if (content._ === "messageText") {
        const cards = findCards(content.text.text);

        if (cards.length > 0) {
          const areAllCardsValid = cardVerification(cards, validCards);
          if (!areAllCardsValid) {
            botSendMessage(
              `The ${me.first_name} ${me.last_name} sent a message with an unknown card
            text: ${content.text.text}
              `,
              CHANNEL_ID
            );
          }
        }
      }

      if (content._ === "messagePhoto") {
        const cards = findCards(content.caption.text);
        if (cards.length > 0) {
          const areAllCardsValid = cardVerification(cards, validCards);
          if (!areAllCardsValid) {
            botSendMessage(
              `The ${me.first_name} ${me.last_name} sent a message with an unknown card
            text: ${content.caption.text}
              `,
              CHANNEL_ID
            );
          }
        }
      }
    }
  });
}

module.exports = {
  createTelegramClient,
  startClient,
  registerClient,
  clientPost,
};
