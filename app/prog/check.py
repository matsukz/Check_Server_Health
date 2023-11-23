from ping3 import ping 
import datetime
import json

now = datetime.datetime.now().strftime("%X")
result = {}

def PingCheck():

    # JSONの読み込み
    data = open("/app/prog/CheckList.json","r")
    CheckList = json.load(data)

    for key in CheckList.keys(): #keyを取得するループ
        for i in CheckList: # PING結果を格納するループ
            if ping(CheckList[key]["ip"]) is False:
                CheckList[key]["ping"] = -1
            else:
                # 単位をmsに設定する
                CheckList[i]["ping"] = ping(CheckList[i]["ip"], unit = "ms")

    return CheckList

def free_PingCheck(ip):
    result = {ip:ping(ip)}
    return result


    