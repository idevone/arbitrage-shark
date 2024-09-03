const express = require('express');
const bodyParser = require('body-parser');
const axios = require('axios');

const app = express();
app.use(bodyParser.json());

const TOKEN = '7350016523:AAH2lH7com-uzwERIb8QoDN3QcGz5Wz67dk';
const TELEGRAM_API = `https://api.telegram.org/bot${TOKEN}`;

app.post('/webhook', async (req, res) => {
  const { message } = req.body;

  console.log(req.body);

  if (message) {
    const chatId = message.chat.id;
    const text = message.text;

    await axios.post(`${TELEGRAM_API}/sendMessage`, {
      chat_id: chatId,
      text: `Вы написали: ${text}`
    });
  }

  res.send('ok');
});

app.listen(3000, () => {
  console.log('Server is running on port 3000');
});
