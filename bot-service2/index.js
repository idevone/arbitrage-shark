const express = require('express');
const bodyParser = require('body-parser');
// const axios = require('axios');

const app = express();
app.use(bodyParser.json());

app.post('/webhook', async (req, res) => {
  // const { message } = req.body;
    const { chat_join_request } = req.body

  console.log(req.body);

  if (chat_join_request) {
    const chat_id = chat_join_request.chat.id;
    const from_info = chat_join_request.from;
    console.log(chat_id, from_info);
  }

  // if (message) {
  //   const chatId = message.chat.id;
  //   const text = message.text;
  //
  //   await axios.post(`${TELEGRAM_API}/sendMessage`, {
  //     chat_id: chatId,
  //     text: `Вы написали: ${text}`
  //   });
  // }
  /*
{
  update_id: 442421745,
  chat_join_request: {
    chat: { id: -1002181327945, title: '23213213', type: 'channel' },
    from: {
      id: 5844277579,
      is_bot: false,
      first_name: 'Vlad',
      username: 'Ukrainian_brandd',
      language_code: 'ru'
    },
    user_chat_id: 5844277579,
    date: 1725371170,
    invite_link: {
      invite_link: 'https://t.me/+DITgiLXV...',
      creator: [Object],
      pending_join_request_count: 2,
      creates_join_request: true,
      is_primary: false,
      is_revoked: false
    }
  }
}

  * */
  res.send('ok');
});

app.listen(3000, () => {
  console.log('Server is running on port 3000');
});
