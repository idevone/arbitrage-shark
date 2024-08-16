import asyncio
import logging
from concurrent.futures import ThreadPoolExecutor
from aiogram import Bot, Dispatcher, types, F
from services.update_user import update_db
from config import BOT_TOKEN

# Create ThreadPoolExecutor for concurrent tasks
executor = ThreadPoolExecutor(max_workers=5)


async def chat_join_request(chat_join: types.ChatJoinRequest):
    await chat_join.approve()

    user_id = chat_join.from_user.id
    invite_link = chat_join.invite_link
    if invite_link:
        logging.info(
            f"User {user_id} joined via invite link: {invite_link.invite_link}"
        )
        _, code = invite_link.invite_link.split("+", 1)
        try:
            await asyncio.get_event_loop().run_in_executor(
                executor, update_db, user_id, code
            )
        except Exception as e:
            logging.error(f"Error updating DB: {e}")
    else:
        logging.warning("Invite link is missing or invalid")


async def main():
    logging.basicConfig(level=logging.INFO)
    bot = Bot(token=BOT_TOKEN)
    dp = Dispatcher()

    dp.chat_join_request.register(chat_join_request, F.chat.id == -1002186034668)

    await bot.delete_webhook(drop_pending_updates=True)
    await dp.start_polling(bot, allowed_updates=dp.resolve_used_update_types())


if __name__ == "__main__":
    asyncio.run(main())
