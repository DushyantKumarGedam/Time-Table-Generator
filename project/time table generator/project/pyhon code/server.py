# server.py
from flask import Flask, render_template
import subprocess

app = Flask(__name__)

app.config['DEBUG'] = True


@app.route('/')
def index():
    return render_template('generate.php')

@app.route('/generate_timetable')
def generate_timetable():
    # Execute the Python script and capture its output
    result = subprocess.check_output(['python', 'display_timetable.py'], universal_newlines=True)
    return result

if __name__ == '__main__':
    app.run(debug=True)
