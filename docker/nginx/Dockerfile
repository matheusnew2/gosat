FROM node:lts-alpine as build-vue

WORKDIR /var/www/html/vue
COPY package*.json ./
COPY vue .
RUN npm install
RUN npm run build


FROM nginx:stable-alpine
WORKDIR /var/www/html
COPY ./docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY --from=build-vue /var/www/html/vue/dist /var/www/html/vue/dist


EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]


 