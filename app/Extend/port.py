import socket
from datetime import datetime, timedelta, timezone

def check_ports(ip,port,option):
    service = ""
    result = {}
    try:
        with socket.create_connection((ip,port),timeout=2):
            service = True
    except:
        service = False
    
    if option == "1":
        result["Time"] = str(datetime.now(timezone(timedelta(hours=9))))
        result["RemoteServer"] = ip
        result["Port"] = port
        result["Result"] = service
    else:
        result["Result"] = service      
    
    return result