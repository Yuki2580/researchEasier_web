import json
import urllib.request
import sys
#import base64
print(sys.argv[1])
#content = json.loads(base64.b64decode(sys.argv[1]))
#print("ITTTTTT" + sys.argv)
#print ("Hello")
#data = json.loads(sys.argv[1])
#foods = json.dumps(data)
#print(content)

#import ssl
#ssl._create_default_https_context = ssl._create_unverified_context

def search_paper():
    api_key = "f9483d19cf45426e85d10d305e194abb"
    w = sys.argv[1]
    print("!!!!!!!!!!!!!!!!!!!!")
    print(w)
    #query=""
    query = "And(W='" + w + "'" + ",Y=2020)"
    #query = "And(W='science',Y=2020)"
    #query2 = "And(W='deep',W='learning',Y=2020)"
    url = "https://api.labs.cognitive.microsoft.com/academic/v1.0/evaluate?"+"expr="+query+"&attributes=Ti,S,VFN&count=3"

    request = urllib.request.Request(
        url,
        method="GET",
        headers={"Ocp-Apim-Subscription-Key" : api_key},
    )

    with urllib.request.urlopen(request) as response:
        response_body = json.loads(response.read().decode('utf-8'))

    for e in response_body['entities']:
        message = "*Title* : {}\n*Journal* : {}\n*URL* : {}".format(e['Ti'],e['VFN'],e['S'][0]['U'])
        print(message)

#search_paper();
