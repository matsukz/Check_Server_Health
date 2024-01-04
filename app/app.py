from flask import Flask, redirect, render_template, request, jsonify
import os
from ping3 import ping 

from Extend import ping
from Extend import port
app = Flask(__name__)

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

@app.route("/ping")
def route_ping():

    ip = option = ""

    ip = request.args.get("ip")
    option = request.args.get("option")

    if ip is None:
        return jsonify({"Result":"Error Required parameter does not exist."}), 500
    else:
        return ping.check_ping(ip,option)
    
if __name__ == "__main__":
    app.run(debug=True, host="0.0.0.0")