const Router = require("express");
const { register } = require("../controllers/usersControllers");
const router = new Router();

router.post("/register", register);

module.exports = router;
