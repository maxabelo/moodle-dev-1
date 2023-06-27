FROM node:18.12-alpine3.16

# Create app directory
WORKDIR /home/node/app/

COPY . .

RUN npm i

EXPOSE 80

CMD ["node","bin/www"]


