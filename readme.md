# サーバーの稼働状況をチェックするやーつ
各種サーバーがオンラインなのかオフラインなのかを確認するサイトです。

## 使うには？
docker-composeを利用してください。

cloudflaredを利用して安全にWebサイトを公開しましょう。
## 確認方法
### ポートを確認する
* Python(Flask)がSocketでサーバーのポートに対し通信を行う。
* 通信が確認するとオンラインになる

### HTTPで確認する
* Webサーバーに対しphp_curlで通信を行い、レスポンスコードが`200`なら接続成功です。
* ポートが`80`もしくは`8080`の場合
### WARPを確認する
* IPアドレスにWARPから割り当てられたIPアドレスを用いることで、WARP通信が正常かを確認する
* WARPへの参加、もしくはルーティングが必要です

## 確認を行うサーバーの指定方法
`content.php`と同じ場所に`Client.json`を作成します
* 内容
```json
"Server1":{
    "id":"Server1-id",
    "IP":"192.168.11.16",
    "WARP":"100.96.0.1",
    "Port":{
        "SSH":22,
        "Apache":80,
        "Nginx":8080
    },
    "URLPath":"/index.php"
}
```
|キー|値|
|:---:|:---:|
||サイトに表示するサーバー名|
|id|HTMLで用いるid(空白禁止)|
|IP|サーバーのIPアドレス|
|WARP|WARPから割り当てられたIPアドレス(省略可)|
|Port|サービスとポートを設定|
|URLPath|HTTPで確認するときに用いるURL(省略可)|

## まとめ
ポート開放不要なのが最高すぎる

2024-11-17