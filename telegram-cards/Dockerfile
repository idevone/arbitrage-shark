# Використання базового образу Node.js
FROM node:18-alpine
# Встановлення Python, make і g++ для компіляції нативних модулів
RUN apk add --no-cache python3 make g++

# Встановлення робочого каталогу в контейнері
WORKDIR /app

# Копіювання package.json та package-lock.json до контейнера
COPY package*.json ./

# Встановлення залежностей
RUN npm install --production

# Копіювання всіх файлів до робочого каталогу контейнера
COPY . .

# Встановлення порту, який контейнер буде слухати
EXPOSE 3000

# Команда для запуску додатку
CMD ["npm", "start"]
