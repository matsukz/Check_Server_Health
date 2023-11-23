from ping3 import ping 
import datetime

now = datetime.datetime.now().strftime("%X")
result = {}

def PingCheck():

    # pingを実行するIPアドレス（第4オクテット）

    CheckList = {
        "Archer AX73" : {
            "ip": "192.168.0.1",
            "ping": -1
        },

        "WEX-1166DHPS": {
            "ip": "192.168.0.3",
            "ping": -1
        },

        "Xperia XZ": {
            "ip": "192.168.0.4",
            "ping": -1
        }
    }
    for key in CheckList.keys(): #keyを取得するループ
        for i in CheckList: # 結果を格納するループ
            if ping(CheckList[key]["ip"]) is False:
                CheckList[key]["ping"] = -1
            else:
                # CheckList[i]["ping"] = "{:.3f}".format(ping(CheckList[i]["ip"]) * 1000) + "ms"
                CheckList[i]["ping"] = ping(CheckList[i]["ip"], unit = "ms")

    return CheckList

def free_PingCheck(ip):
    result = {ip:ping(ip)}
    return result


    