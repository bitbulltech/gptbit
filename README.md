# gptbit
<h2>GPTbit: Create a Chatbot with Custom Data by using ChatGPT</h2>

<b>Introduction</b>: 
GPTbit is an experimental open source application to create chatbot which returns response from custom data.
It use Open AI chatGPT APIs to acheive the functionality.

You can upload multiple doc file (.docx format) or .txt file to create data library.
It support content like text, images and Mathematical equations.


<b>Application</b>:
1) You can create chatbot for your website by adding all required information in docx file.
Example: If you are running any educational institute and your website contain information like about history, courses, fee structure and other facilities then you can create multiple docx files of these information and build chatbot to answer website visitor's queries.
2) Create chatbot for training acivities. 
3) Create chatbot to generate a quick report from custom data

<b>Requirements</b>:
1) PHP 7+ (php ZipArchive required)
2) Python 2+ (OpenAI required)

No database required for default functionalities.


<b>Installation</b>
1) Upload all files to server
2) Open config.php file and add openai api key and absolute path of server
3) Make sure following directories has writeable permission
   upload, upload/word_images, zip, rfor, data




