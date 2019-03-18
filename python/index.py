#!C:\Python34\python.exe
print()

import pymysql
import os as application
from berserker_resolver import Resolver

host="dexr-production-2.ci0hkmciekd6.us-east-2.rds.amazonaws.com"
port="3306"
user="dexrdb"
passwd="dexrdbpass"
db="ebdb"


conn = pymysql.connect(host=host, port=3306, user=user, passwd=passwd, db=db)

cur = conn.cursor()

cur.execute("SELECT domain_name FROM user_1_3526197866 LIMIT 1000")

domains = []

if cur is not None:
    for row in cur:
        domains.append(row[0])
else:
    response = b"cur is empty"

conn.commit()
cur.close()

resolver = Resolver(www=True, www_combine=True, verbose=True, timeout=2, tries=1, threads=500)
result = resolver.resolve(domains)

activeDomains = []

if result['success'] is not None:
    for d in result['success']:
        if d in domains:
            activeDomains.append(d)
else:
    response = b"d is empty"

response = ' '.join(activeDomains)

if response is None:
    print("GRRRRRRRRRRRRRRRRRR")
else:
    print(response)
    