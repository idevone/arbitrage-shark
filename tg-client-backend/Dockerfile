FROM node:latest

WORKDIR /usr/src/app

COPY package*.json ./

RUN npm install

RUN npm install -g pm2

COPY . .

RUN npm run build

EXPOSE 5001

CMD ["pm2", "start", "dist/index.js", "--name", "tg-client-backend", "--no-daemon"]