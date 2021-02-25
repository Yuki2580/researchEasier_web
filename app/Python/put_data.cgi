import json
import urllib.request
import sys,io
sys.stdout = io.TextIOWrapper(sys.stdout.buffer, encoding='utf-8') 

#import base64
#print(sys.argv[1])
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

#    print("!!!!!!!!!!!!!!!!!!!!")
#    print(w)
    #query=""
    query = "Id=" + w
    #query = "And(W='science',Y=2020)"
    #query2 = "And(W='deep',W='learning',Y=2020)"
    url = "https://api.labs.cognitive.microsoft.com/academic/v1.0/evaluate?"+"expr="+query+"&attributes=Ti,S,Y,VFN,FP,I,V,LP,AA.AuN,Id,BT,PB,CC&count=30"

    request = urllib.request.Request(
        url,
        method="GET",
        headers={"Ocp-Apim-Subscription-Key" : api_key},
    )

    with urllib.request.urlopen(request) as response:
        response_body = json.loads(response.read().decode('utf-8'))



    for e in response_body['entities']:
        Ti = e.get('Ti')
        Y = e.get('Y')
        VFN = e.get('VFN')
        FP = e.get('FP')
        LP = e.get('LP')
        V = e.get('V')
        I = e.get('I')
        Id = e.get('Id')
        BT = e.get('BT')
        PB = e.get('PB')
        CC = e.get('CC')
        if 'S' in e:
            S = e['S'][0]['U']
        else:
            S="NULL"
        message2 = ""
        message = "{}\n{}\n{}\n{}\n{}\n{}\n{}\n{}\n{}\n{}\n{}\n{}".format(Ti,Y,Id,VFN,CC,PB,FP,LP,V,I,S,BT)
        print(message)
        for e2, e3 in enumerate(e['AA']):
            message2 += "{}, ".format(e3['AuN'])
        print(message2)
    #for e in response_body['entities']:
#        for e2 in enumerate(e['AA']):
#            message = "{}\n".format(e2)
#            print(message)

search_paper()
