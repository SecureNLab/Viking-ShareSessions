#!/bin/bash

# 启动SSH服务
service ssh start

# 在前台模式下启动Redis
redis-server --daemonize no --protected-mode no

# 保持容器运行
tail -f /dev/null
