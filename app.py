from flask import Flask, jsonify, request
import mysql.connector
import jwt
import datetime
from functools import wraps
from werkzeug.security import check_password_hash, generate_password_hash

app = Flask(__name__)

mydb = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="help_pinoy"
)
app.config['SECRET_KEY'] = 'thisissecret'


def token_required(f):
    @wraps(f)
    def decorated(*args, **kwargs):
        token = request.headers.get('x-access-token')
        if token == False:
            return jsonify({'status': 'error', 'message': 'bno token'})
        try:
            data = jwt.decode(token, app.config['SECRET_KEY'], algorithms=["HS256"])
            cursor = mydb.cursor(dictionary=True)
            cursor.execute("SELECT * FROM users WHERE id = %s AND role = 'Admin'", (data['id'],))
            current_user = cursor.fetchone()
            cursor.close()
            if not current_user:
                return jsonify({'status': 'error', 'message': 'Invalid'})
        except jwt.ExpiredSignatureError:
            return jsonify({'status': 'error', 'message': 'expired'})
        except jwt.InvalidTokenError:
            return jsonify({'status': 'error', 'message': 'Invalid'})

        return f(current_user, *args, **kwargs)

    return decorated

# Admin Login - Returns JWT Token
@app.route('/admin_login', methods=['POST'])
def admin_login():
    data = request.get_json()
    email = data['email']
    password = data['password']

    cursor = mydb.cursor(dictionary=True)
    cursor.execute("SELECT id, name, email, password FROM users WHERE email = %s AND role = 'Admin'", (email,))
    user = cursor.fetchone()
    cursor.close()

    if user and check_password_hash(user['password'], password):
        token = jwt.encode({
            'id': user['id'],
            'exp': datetime.datetime.now(datetime.timezone.utc) + datetime.timedelta(seconds=40)  # Token expires in 1 hour
        }, app.config['SECRET_KEY'], algorithm="HS256")

        return jsonify({'status': 'success', 'token': token, 'admin': {'id': user['id'], 'name': user['name'], 'email': user['email']}})
    else:
        return jsonify({'status': 'error', 'message': 'Invalid email or password'})


@app.route('/dashboard_data', methods=['GET'])

def dashboard_data():
    cursor = mydb.cursor(dictionary=True)

    #donations sum
    cursor.execute("SELECT SUM(amount) AS total FROM donations")
    sd = cursor.fetchone()['total']

    #per month donations sum
    cursor.execute("SELECT SUM(amount) AS total FROM donations WHERE MONTH(donation_date) = MONTH(CURDATE()) AND YEAR(donation_date) = YEAR(CURDATE())")
    sd_month = cursor.fetchone()['total']

    #donors count
    cursor.execute("SELECT COUNT(DISTINCT donor_id) AS total FROM donations")
    td = cursor.fetchone()['total']

    #users count
    cursor.execute("SELECT COUNT(*) AS total FROM users")
    tu = cursor.fetchone()['total']


    cursor.close()
    return jsonify({
        'sd': sd,
        'sd_month': sd_month,
        'td': td,
        'tu': tu
    })

# Display donations
@app.route('/donations', methods=['GET'])
def get_donations():
    cursor = mydb.cursor(dictionary=True)
    cursor.execute("SELECT reference_number, donor_id,donor_name, amount, payment_method, donation_date FROM donations")
    donations = cursor.fetchall()
    cursor.close()
    return jsonify(donations)

# Display users
@app.route('/get_users', methods=['GET'])
def get_users():
    cursor = mydb.cursor(dictionary=True)
    cursor.execute('SELECT id, name, email, role, created_at FROM users')
    users = cursor.fetchall()
    cursor.close()
    return jsonify(users)

# Add user
@app.route('/add_user', methods=['POST'])
def add_user():
    data = request.get_json()
    name = data['name']
    email = data['email']
    password = data['password']
    role = data['role']

    hashed_password = generate_password_hash(password)

    cursor = mydb.cursor()
    cursor.execute('INSERT INTO users (name, email, password, role) VALUES (%s, %s, %s, %s)', 
                   (name, email, hashed_password, role))
    mydb.commit()
    cursor.close()

    return jsonify({'status': 'success', 'print': 'User added successfully'})

#edit user
@app.route('/edit_user', methods=['POST'])
def update_user():
    data = request.get_json()
    user_id = data['user_id']
    name = data['name']
    email = data['email']
    role = data['role']
    cursor = mydb.cursor()
    cursor.execute('UPDATE users SET name = %s, email = %s, role = %s WHERE id = %s', (name, email, role, user_id))
    mydb.commit()
    cursor.close()
    return jsonify({'status': 'success', 'print': 'User updated successfully'})

#delete user
@app.route('/delete_user', methods=['POST'])
def delete_user():
    data = request.get_json()
    user_id = data['user_id']
    
    cursor = mydb.cursor()
    cursor.execute('DELETE FROM users WHERE id = %s', (user_id,))
    mydb.commit()
    cursor.close()
    return jsonify({'status': 'success', 'print': 'User deleted successfully'})



# Display location
@app.route('/get_locations', methods=['GET'])
def get_locations():
    cursor = mydb.cursor(dictionary=True)
    cursor.execute('SELECT id, name, address, latitude, longitude FROM locations')
    locations = cursor.fetchall()
    cursor.close()
    return jsonify(locations)

# Add location
@app.route('/add_location', methods=['POST'])
def add_location():
    data = request.get_json()
    name = data['name']
    address = data['address']
    latitude = data['latitude']
    longitude = data['longitude']
    
    cursor = mydb.cursor()
    cursor.execute('INSERT INTO locations (name, address, latitude, longitude) VALUES (%s, %s, %s, %s)', 
                   (name, address, latitude, longitude))
    mydb.commit()
    cursor.close()
    
    return jsonify({'status': 'success', 'print': 'Location added successfully'})

#delete location
@app.route('/delete_location', methods=['POST'])
def delete_location():
    data = request.get_json()
    location_id = data['location_id']
    cursor = mydb.cursor()
    cursor.execute('DELETE FROM locations WHERE id = %s', (location_id,))
    mydb.commit()
    cursor.close()
    return jsonify({'status': 'success', 'print': 'Location deleted successfully'})

#edit location
@app.route('/edit_location', methods=['POST'])
def edit_location():
    data = request.get_json()
    location_id = data['location_id']
    name = data['name']
    address = data['address']
    latitude = data['latitude']
    longitude = data['longitude']
    cursor = mydb.cursor()
    cursor.execute('UPDATE locations SET name = %s, address = %s, latitude = %s, longitude = %s WHERE id = %s', (name, address, latitude, longitude, location_id))
    mydb.commit()
    cursor.close()
    return jsonify({'status': 'success', 'print': 'Location updated successfully'})



if __name__ == '__main__':
    app.run(debug=True)
