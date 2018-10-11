var http = require('http');

http.createServer(function(request,response){
	response.writeHead(200,{'Content-Type': 'text/plain'});

	response.end('Hello World! from nodejs');
}).listen(8005);

console.log('Server running at http://127.0.0.1:8005/');
