const {
  createTelegramClient,
  registerClient,
  startClient,
  clientPost,
} = require("../services/telegramClient");

const register = async (req, res, next) => {
  try {
    const { phoneNumber, code, password } = req.body;
    if (!phoneNumber) {
      return res.status(400).json({ message: "phone number is required" });
    }
    createTelegramClient(phoneNumber);

    const status = await registerClient({ phoneNumber });

    if (status === "authorizationStateWaitPhoneNumber") {
      try {
        const result = await clientPost(phoneNumber, {
          "@type": "setAuthenticationPhoneNumber",
          phone_number: phoneNumber,
        });
        return res.status(200).json({
          status: result._,
          message: "Activation code has been sent",
        });
      } catch (e) {
        console.error(e);
        return res.status(400).json({ message: e });
      }
    } else if (status === "authorizationStateWaitCode") {
      try {
        const result = await clientPost(phoneNumber, {
          "@type": "checkAuthenticationCode",
          code,
        });
        return res.status(200).json({
          status: result._,
        });
      } catch (e) {
        console.error(e);
        return res.status(400).json({ message: e });
      }
    } else if (status === "authorizationStateWaitPassword") {
      try {
        const result = await clientPost(phoneNumber, {
          "@type": "checkAuthenticationPassword",
          password,
        });
        return res.status(200).json({
          status: result._,
        });
      } catch (e) {
        console.error(e);
        return res.status(400).json({ message: e });
      }
    } else if (status === "authorizationStateReady") {
      await startClient(phoneNumber);
      return res.status(200).json({
        status: "ok",
        message: "The user is activated and the client is started",
      });
    }

    return res.status(200).json({ message: "The user is registered" });
  } catch (e) {
    console.error(e);
    res.status(500).json({ message: "server error" });
  }
};

module.exports = {
  register,
};
