import sys
import openai
openai.api_key = sys.argv[1];
prompt =  sys.argv[2];
prompt2 =  sys.argv[3];
completions = openai.Completion.create(engine=prompt2, prompt=prompt, max_tokens=1024, n=1,stop=None,temperature=0.7)
message = completions.choices[0].text
print(message)
