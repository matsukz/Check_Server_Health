from flask import Flask, redirect, render_template, request, jsonify
from flask_cors import CORS
from ping3 import ping

import os
import time
from prog import check
app = Flask(__name__)

#Access-Control-Allow-Originへの対処
cors = CORS(app, resources={r"/*": {"origins": "*"}})

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

@app.route("/ping-ajax-get", methods=["GET"])
def ajax_get():
    time.sleep(5)
    return jsonify(data="Your data is ready!")

if __name__ == "__main__":
    app.run(debug=True, host="0.0.0.0")