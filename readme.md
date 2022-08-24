#README____
##Перед запуском следует:
____
1. Установить прокси-сервер. В данном случае используется mitmproxy: https://docs.mitmproxy.org/stable/
2. Вероятно текущий chromeriver уже устарел, поэтому нужно скачать новый https://chromedriver.chromium.org/downloads и заменить в проекте старый chromedriver.exe новым 
##Команды для запуска:
java -jar selenium-server-standalone-3.141.59.jar - для запуска selenium 
mitmdump -p 8080 -s "proxy-server.py" - для запуска прокси-сервера
