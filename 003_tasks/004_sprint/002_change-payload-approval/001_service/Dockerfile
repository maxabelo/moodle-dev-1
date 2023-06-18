FROM node:18.12-alpine3.16

# Create app directory
WORKDIR /home/node/app/

COPY . .

RUN npm i
RUN npm i nodemon

# EXPOSE 3333 ## afuera
EXPOSE 8080

# CMD ["node","bin/www"]
CMD ["npx","nodemon","bin/www"]


