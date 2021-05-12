FROM node:16-alpine3.11 as node

WORKDIR /app

COPY ./package.json ./

RUN npm install

COPY ./ ./

RUN npm run prod

FROM nginx:1.19-alpine

COPY ./docker/production/nginx/config/default.conf /etc/nginx/conf.d/default.conf

WORKDIR /var/www

COPY --from=node /app/public/ ./public/
