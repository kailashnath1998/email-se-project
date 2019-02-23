from bottle import route, run, request, response, Bottle
import random
import json
import datetime
import logging
import sys
from bottle import static_file
import json
import re

logging.basicConfig(level=logging.INFO)



app = Bottle()

# define routes

@app.route('/', method='GET')
def home():
    return static_file('index.html', root='./')


@app.route('/js/<filename:re:.*\.js>')
def js(filename):
    return static_file(filename, root='./static/js/')


@app.route('/css/:filename#.*#')
def css(filename):
    return static_file(filename, root='./static/css/')


@app.route('/assets/:filename#.*#')
def css(filename):
    return static_file(filename, root='./static/assets/')


@app.hook('after_request')
def enable_cors():
    """
    You need to add some headers to each request.
    Don't use the wildcard '*' for Access-Control-Allow-Origin in production.
    """
    response.headers['Access-Control-Allow-Origin'] = '*'
    response.headers['Access-Control-Allow-Methods'] = 'PUT, GET, POST, DELETE, OPTIONS'
    response.headers['Access-Control-Allow-Headers'] = 'Origin, Accept, Content-Type, X-Requested-With, X-CSRF-Token'




run(app, host='0.0.0.0', port=6789, reloader=True, debug=True)
