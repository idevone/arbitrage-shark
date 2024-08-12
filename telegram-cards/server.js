require("dotenv").config();
const express = require("express");
const usersRoutes = require("./src/routes/usersRoutes");
const app = express();
app.use(express.json());

app.use("/api/users", usersRoutes);

const { SERVER_PORT = 5001 } = process.env;

const start = async () => {
  try {
    const server = app.listen(SERVER_PORT, () =>
      console.log(`server started on port: ${SERVER_PORT}`)
    );
  } catch (e) {
    console.error(e);
  }
};

start();
