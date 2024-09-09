FROM node:22-alpine

WORKDIR /usr/src/app

COPY package*.json ./

RUN npm install

RUN npm install pm2 -g
ENV PM2_PUBLIC_KEY y33e3y0hhhqbxfa
ENV PM2_SECRET_KEY z6cnw3dimb0987c

COPY . .

RUN npm run build

CMD ["pm2-runtime", "dist/main.js", "--no-daemon"]

EXPOSE 3000