from flask import Flask, redirect, render_template, request
import os
from ping3 import ping 

from prog import check
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

if __name__ == "__main__":
    app.run(debug=True, host="0.0.0.0")