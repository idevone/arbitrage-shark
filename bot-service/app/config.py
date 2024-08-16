import os

# Telegram Bot Token
BOT_TOKEN = os.getenv('BOT_TOKEN', 'your-telegram-bot-token')

# Database Config
DB_HOST = os.getenv('DB_HOST', 'your-db-host')
DB_PORT = os.getenv('DB_PORT', 'your-db-port')
DB_USER = os.getenv('DB_USER', 'your-db-user')
DB_PASSWORD = os.getenv('DB_PASSWORD', 'your-db-password')
DB_NAME = os.getenv('DB_NAME', 'your-db-name')

DATABASE_URL = f"postgresql://{DB_USER}:{DB_PASSWORD}@{DB_HOST}:{DB_PORT}/{DB_NAME}"

# Facebook Pixel API
FACEBOOK_PIXEL_API = os.getenv('FACEBOOK_PIXEL_API', 'your-facebook-pixel-api')
