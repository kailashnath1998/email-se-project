from bottle import route, run, request, response, Bottle,template
import bottle
import random
import json
import datetime
import logging
import sys
from bottle import static_file
import json
import re
import os     

logging.basicConfig(level=logging.INFO)



app = Bottle()

# define routes


@app.route('/', method='GET')
def main():
    return static_file('landing.html', root='./static')


@app.route('/<filename:re:.*\.html>', method='GET')
def home(filename):
    return static_file(filename, root='./static')


@app.route('/<id>', method = 'GET')
def forward(id):
	if id == 'admin':
		return static_file('admin.html', root='./static')
	elif request.query['type'] == 'fwd':
		return template('test.tpl', {'id' : id})
	elif request.query['type'] == 'rply':
		return template('test1.tpl', {'id' : id})
	elif request.query['type'] == 'dedit':
		return template('test2.tpl', {'id' : id})


@app.route('/js/<filename:re:.*\.js>')
def js(filename):
    return static_file(filename, root='./static/js/')


@app.route('/css/:filename#.*#')
def css(filename):
    return static_file(filename, root='./static/css/')


@app.route('/assets/:filename#.*#')
def css(filename):
    return static_file(filename, root='./static/assets/')

@app.get('/favicon.ico')
def get_favicon():
    return static_file('favicon.ico', root='./static/assets/')


@app.hook('after_request')
def enable_cors():
    """
    You need to add some headers to each request.
    Don't use the wildcard '*' for Access-Control-Allow-Origin in production.
    """
    response.headers['Access-Control-Allow-Origin'] = '*'
    response.headers['Access-Control-Allow-Methods'] = 'PUT, GET, POST, DELETE, OPTIONS'
    response.headers['Access-Control-Allow-Headers'] = 'Origin, Accept, Content-Type, X-Requested-With, X-CSRF-Token'




run(app, host='0.0.0.0', port=3000, reloader=True, debug=True)
