#!C:\Python34\python.exe
print()

import cgi
import pymysql
import os as application
from berserker_resolver import Resolver

GET={}
args=application.getenv("QUERY_STRING").split('&')

for arg in args: 
    t=arg.split('=')
    if len(t)>1: k,v=arg.split('='); GET[k]=v

host="dexr-production-2.ci0hkmciekd6.us-east-2.rds.amazonaws.com"
port="3306"
user="dexrdb"
passwd="dexrdbpass"
db="ebdb"


conn = pymysql.connect(host=host, port=3306, user=user, passwd=passwd, db=db)

cur = conn.cursor()
cur2 = conn.cursor()
cur3 = conn.cursor()

cur.execute("SELECT domain_name FROM " + GET.get('table') + " WHERE crawled = '0' LIMIT 500")

domains = []

if cur is not None:
    for row in cur:
        domains.append(row[0])
        cur3.execute("UPDATE " + GET.get('table') + " SET crawled = 1 WHERE domain_name = '" + row[0] + "'")
else:
    response = b"cur is empty"

resolver = Resolver(www=True, www_combine=True, verbose=True, timeout=2, tries=1, threads=500)
result = resolver.resolve(domains)

activeDomains = []

if result['success'] is not None:
    for d in result['success']:
        if d in domains:
            activeDomains.append(d)
            cur2.execute("UPDATE " + GET.get('table') + " SET active = 1 WHERE domain_name = '" + d + "'")
else:
    response = b"d is empty"

conn.commit()
cur2.close()
cur.close()
cur3.close()

response = ' '.join(activeDomains)

if response is None:
    print("GRRRRRRRRRRRRRRRRRR")
else:
    print(response)
    
print('<meta http-equiv="refresh" content="1">')