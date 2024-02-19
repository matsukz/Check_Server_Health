from ping3 import ping 
from datetime import datetime, timedelta, timezone

def check_ping(ip,option):
    result = {}
    ping_result = -1

    result["Result"] = ping_result
    
    if option == "1":
        result["Time"] = str(datetime.now(timezone(timedelta(hours=9))))
        result["RemoteServer"] = ip
    elif option == "2":
        return str(ping(ip,timeout=2,unit="ms"))
    else:
        pass

    ping_result = ping(ip,timeout=2,unit="ms")

    result["Result"] = ping_result

    return result