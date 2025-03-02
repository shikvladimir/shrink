#FROM node:20
#RUN apt-get update && apt-get install -y \
#    vim \
#    zip \
#    unzip \
#    curl
#USER root
#EXPOSE 5173
#WORKDIR /var/vue
#CMD ["bash", "-c", "npm install && npm run dev"]

FROM ubuntu:latest
USER root
WORKDIR /var/vue
COPY ./vue/package.json /var/vue/package.json
RUN apt-get update
RUN apt-get -y install curl gnupg
RUN curl -sL https://deb.nodesource.com/setup_20.x  | bash -
RUN apt-get -y install nodejs
RUN npm install
EXPOSE 5173
CMD ["sh", "-c", "npm install && npm run dev -- --host"]