# PINGチェックするやーつ
サーバーのPINGをWebブラウザで確認する
## 構成

* ディレクトリ
    ```
        app
        ├ prog
        │ └ check.py
        ├ static
        │ └ js
        │ 　 └ (JavaScript)
        ├ templates
        │ ├ css
        │ │ ├ (BootStrap5 - CSS)
        │ │ └ (BootStrap5 - js)
        │ ├ index.html
        │ └ layout.html
        ├ app.py
        ├ dockerfile
        └ requirements.txt
        docker-compose.yaml
        readme.md
    ```

* docker-compose
    ```bash
    $ docker-compose -v
    Docker Compose version v2.15.1
    ```
* Python
    * Flask
    * requests
    * ping3

## ファイルの内容
### docker-compose.yml
* flask用のPythonを準備します