FROM node:18.16.0 as build

WORKDIR /app

COPY ./ .

RUN npm ci --silent
RUN npm run build --if-present

FROM nginx

COPY ./nginx.conf /etc/nginx/nginx.conf
COPY --from=build /app/dist /usr/share/nginx/html

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
