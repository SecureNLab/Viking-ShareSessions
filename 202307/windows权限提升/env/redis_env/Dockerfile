#Redis is not authorized to access

FROM ubuntu

MAINTAINER D4wn


RUN apt-get update
RUN apt-get install -y openssh-server
RUN apt-get install -y redis-server
RUN mkdir /root/.ssh
# 自定义入口脚本
RUN chmod +r /etc/redis/redis.conf
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 6379
EXPOSE 22

ENTRYPOINT ["/entrypoint.sh"]