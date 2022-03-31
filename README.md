# PHP Server Information
This application is designed to provide information about IBM Power server models, when searched for by machine type and model. It was written in PHP and is designed to be deployed using the Source to Image (s2i) capabilities within Red Hat OpenShift Container Platform.
This application uses other services to pull in the relevant information:

- *smfinder* - to lookup the correct URL of the relevant Sales Manual
- *smreader* - to pull out the important dates from the Sales Manual entry
- *nodejs-mongodb-reader* to access performance figures from a MongoDB database using an API

These can be deployed from other GitHub repositories:

[https://github.com/andrewlaidlaw/node-red-sales-manual](https://github.com/andrewlaidlaw/node-red-sales-manual)
[https://github.com/andrewlaidlaw/nodered-mongodb](https://github.com/andrewlaidlaw/nodered-mongodb)