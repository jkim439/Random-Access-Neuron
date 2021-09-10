import os
import json

functions = os.listdir(os.getcwd())


list_functions = []
for f in functions:
    if not f.startswith('.') and not f.endswith('.py'):
        list_functions.append(f)



lambda_list_json = json.loads(os.popen('aws lambda list-functions').read())

functions = lambda_list_json['Functions']

list_function_online = []
for f in functions:
    list_function_online.append(f['FunctionName'])



print("list of local functions = " + str(list_functions))
print("list of AWS functions = " + str(list_function_online))

for f in list_functions:
    if(f in list_function_online):
        print('Updating Existing Function on AWS: '+ f)
        os.system('cd '+ f +' ; ' + 'zip -q -r ../'+f + '.zip' + ' . *' + ' ; '+ 'cd ..')

        os.system('aws lambda update-function-code --function-name  '+ f +' --zip-file '+'fileb://' +f+'.zip')
        os.system('rm '+ f +'.zip')
    else:
        print('Creating non-Existing Function on AWS: ' + f)
        os.system('cd '+ f +' ; ' + 'zip -q -r ../'+f + '.zip' + ' . *' + ' ; '+ 'cd ..')

        os.system('aws lambda create-function \
                    --function-name '+ f + ' \
                    --runtime python3.7 \
                    --zip-file '+'fileb://' +f+'.zip \
                    --handler '+ f +'.handler \
                    --role arn:aws:iam::531471861132:role/lambda-role')

        os.system('rm '+ f +'.zip')
