from flask import Flask, redirect, render_template, request, jsonify
import os
from ping3 import ping 

from Extend import check
from Extend import port
app = Flask(__name__)

@app.route("/")
def route():

    return render_template(
        "index.html",
        Resp = check.PingCheck(),
        title = "PING確認"
    )

@app.route("/dict")
def route_api():

    ip = ""
    if request.args.get("ip") is None:
        return check.PingCheck()
    else:
        ip = request.args.get("ip")
        Resp = check.free_PingCheck(ip)
        return Resp

@app.route("/port")
def route_port():

    ip = service = option = ""

    ip = request.args.get("ip")
    service = request.args.get("port")
    option = request.args.get("option")

    if ip is None or service is None:
        return jsonify({"Result":"Error Required parameter does not exist."}), 500
    else:
        return port.check_ports(ip,service,option)
    
if __name__ == "__main__":
    app.run(debug=True, host="0.0.0.0")