FROM ubuntu:latest

RUN apt-get update
RUN apt upgrade -y
RUN apt-get install python3 python3-pip -y

RUN mkdir /app

WORKDIR /app

COPY requirements.txt /app

RUN pip install -r requirements.txt