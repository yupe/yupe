#!/usr/bin/env bash
## 制定脚本执行的是bash shell，强烈建议明确shell，否则脚本执行可能出现意外

## 处理命令之后回显，以便调试脚本
#set -o xtrace

## 强制切换到root权限执行脚本
if [ `whoami` != "root" ]; then
	sudo passwd root
	exec su -c 'sh ./shiftSource.sh'
fi

## 如果最近一次的apt-get install强制中断，修复apt-get install锁定导致不能进行新的安装
if [ -e /var/cache/apt/archives/lock ]; then
rm -rf /var/cache/apt/archives/lock
fi
if [ -e /var/lib/dpkg/lock ]; then
rm -rf /var/lib/dpkg/lock
fi
if [ -e /var/lib/apt/lists/lock ]; then
rm -rf /var/lib/apt/lists/lock
fi

## 切换软件包源，并更新本地的软件包列表
SOURCE_FILE=${SOURCE_FILE:-"/etc/apt/sources.list"}
cp $SOURCE_FILE $SOURCE_FILE.bak

if [ ! -e SOURCE_FILE ]; then
touch $SOURCE_FILE
fi

cat <<EOF >&1
###########################################################
请访问下面网址获取Official Archive Mirrors for Ubuntu。
https://launchpad.net/ubuntu/+archivemirrors

		  切换软件包源:
		  1：中国科学技术大学镜像源
		  2：网易镜像源
		  3：兰州大学镜像源
		  4：本地镜像源
      5：搜狐镜像源
###########################################################
EOF
read step
case $step in
1)
cat <<APT >$SOURCE_FILE
## 中国科学技术大学镜像源，请访问http://home.ustc.edu.cn/~halgu/repogen
  deb http://mirrors.ustc.edu.cn/ubuntu/ precise main restricted universe multiverse
  deb http://mirrors.ustc.edu.cn/ubuntu/ precise-security main restricted universe multiverse
  deb http://mirrors.ustc.edu.cn/ubuntu/ precise-updates main restricted universe multiverse
  deb http://mirrors.ustc.edu.cn/ubuntu/ precise-proposed main restricted universe multiverse
  deb http://mirrors.ustc.edu.cn/ubuntu/ precise-backports main restricted universe multiverse
  deb-src http://mirrors.ustc.edu.cn/ubuntu/ precise main restricted universe multiverse
  deb-src http://mirrors.ustc.edu.cn/ubuntu/ precise-security main restricted universe multiverse
  deb-src http://mirrors.ustc.edu.cn/ubuntu/ precise-updates main restricted universe multiverse
  deb-src http://mirrors.ustc.edu.cn/ubuntu/ precise-proposed main restricted universe multiverse
  deb-src http://mirrors.ustc.edu.cn/ubuntu/ precise-backports main restricted universe multiverse
APT
;;
2)
cat <<APT >$SOURCE_FILE
## 网易镜像源，请访问http://tel.mirrors.163.com/.help/ubuntu.html
  deb http://mirrors.163.com/ubuntu/ precise main restricted universe multiverse              
  deb http://mirrors.163.com/ubuntu/ precise-security main restricted universe multiverse     
  deb http://mirrors.163.com/ubuntu/ precise-updates main restricted universe multiverse      
  deb http://mirrors.163.com/ubuntu/ precise-proposed main restricted universe multiverse     
  deb http://mirrors.163.com/ubuntu/ precise-backports main restricted universe multiverse    
  deb-src http://mirrors.163.com/ubuntu/ precise main restricted universe multiverse          
  deb-src http://mirrors.163.com/ubuntu/ precise-security main restricted universe multiverse 
  deb-src http://mirrors.163.com/ubuntu/ precise-updates main restricted universe multiverse  
  deb-src http://mirrors.163.com/ubuntu/ precise-proposed main restricted universe multiverse 
  deb-src http://mirrors.163.com/ubuntu/ precise-backports main restricted universe multiverse
APT
;;
3)
cat <<APT >$SOURCE_FILE
## 兰州大学镜像源，请访问http://mirror.lzu.edu.cn/
  deb http://mirror.lzu.edu.cn/ubuntu/ precise main restricted universe multiverse
  deb http://mirror.lzu.edu.cn/ubuntu/ precise-security main restricted universe multiverse
  deb http://mirror.lzu.edu.cn/ubuntu/ precise-updates main restricted universe multiverse
  deb http://mirror.lzu.edu.cn/ubuntu/ precise-proposed main restricted universe multiverse
  deb http://mirror.lzu.edu.cn/ubuntu/ precise-backports main restricted universe multiverse
  deb-src http://mirror.lzu.edu.cn/ubuntu/ precise main restricted universe multiverse
  deb-src http://mirror.lzu.edu.cn/ubuntu/ precise-security main restricted universe multiverse
  deb-src http://mirror.lzu.edu.cn/ubuntu/ precise-updates main restricted universe multiverse
  deb-src http://mirror.lzu.edu.cn/ubuntu/ precise-proposed main restricted universe multiverse
  deb-src http://mirror.lzu.edu.cn/ubuntu/ precise-backports main restricted universe multiverse
APT
;;
4)
cat <<APT >$SOURCE_FILE
  deb file:/// debs/
  deb-src file:/// debs/
APT
;;
5)
cat <<APT >$SOURCE_FILE
## 搜狐镜像源，请访问http://mirrors.sohu.com/.help/ubuntu.html
  deb http://mirrors.sohu.com/ubuntu/ precise main restricted universe multiverse              
  deb http://mirrors.sohu.com/ubuntu/ precise-security main restricted universe multiverse     
  deb http://mirrors.sohu.com/ubuntu/ precise-updates main restricted universe multiverse      
  deb http://mirrors.sohu.com/ubuntu/ precise-proposed main restricted universe multiverse     
  deb http://mirrors.sohu.com/ubuntu/ precise-backports main restricted universe multiverse    
  deb-src http://mirrors.sohu.com/ubuntu/ precise main restricted universe multiverse          
  deb-src http://mirrors.sohu.com/ubuntu/ precise-security main restricted universe multiverse 
  deb-src http://mirrors.sohu.com/ubuntu/ precise-updates main restricted universe multiverse  
  deb-src http://mirrors.sohu.com/ubuntu/ precise-proposed main restricted universe multiverse 
  deb-src http://mirrors.sohu.com/ubuntu/ precise-backports main restricted universe multiverse
APT
;;

*)
cat <<EOF >&1
		  输入错误
EOF
esac

apt-get update