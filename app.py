from flask import Flask, render_template, request, redirect, url_for, jsonify
from models import db, ShipSchedule, Ticket
import qrcode

app = Flask(__name__)
app.config['SQLALCHEMY_DATABASE_URI'] = 'sqlite:///database.db'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False

db.init_app(app)

@app.before_first_request
def create_tables():
    db.create_all()

# Home Route (Reservation Page)
@app.route('/')
@app.route('/reservation')
def reservation():
    return render_template('reservation.html')

# About Route
@app.route('/about')
def about():
    return render_template('about.html')

# Management Route (Admin)
@app.route('/management')
def management():
    schedules = ShipSchedule.query.all()
    return render_template('management.html', schedules=schedules)

# Search and Book Ticket
@app.route('/search', methods=['POST'])
def search():
    origin = request.form['origin']
    destination = request.form['destination']
    departure_date = request.form['departure-date']
    ship_class = request.form['class']

    schedules = ShipSchedule.query.filter_by(origin=origin, destination=destination, 
                                             departure_date=departure_date, ship_class=ship_class).all()

    if schedules:
        return render_template('reservation.html', schedules=schedules)
    return "No schedules found."

# Booking a ticket
@app.route('/book_ticket', methods=['POST'])
def book_ticket():
    schedule_id = request.form['schedule_id']
    name = request.form['name']
    schedule = ShipSchedule.query.get(schedule_id)
    
    new_ticket = Ticket(name=name, schedule_id=schedule.id)
    db.session.add(new_ticket)
    db.session.commit()

    # Generate QR Code for the ticket
    qr = qrcode.make(f"ID: {new_ticket.id}, Name: {new_ticket.name}, Schedule ID: {new_ticket.schedule_id}")
    qr.save(f"static/qr_codes/ticket_{new_ticket.id}.png")

    return f"Ticket booked successfully! Download your ticket <a href='/static/qr_codes/ticket_{new_ticket.id}.png'>here</a>."

if __name__ == '__main__':
    app.run(debug=True)

@app.route('/add_schedule', methods=['POST'])
def add_schedule():
    origin = request.form['origin']
    destination = request.form['destination']
    departure_date = request.form['departure_date']
    ship_class = request.form['class']
    ticket_price = request.form['ticket_price']

    new_schedule = ShipSchedule(origin=origin, destination=destination, 
                                departure_date=departure_date, ship_class=ship_class, 
                                ticket_price=ticket_price)
    db.session.add(new_schedule)
    db.session.commit()

    return redirect('/management')
@app.route('/view_schedules')
def view_schedules():
    schedules = ShipSchedule.query.all()
    return jsonify([{
        "id": schedule.id,
        "origin": schedule.origin,
        "destination": schedule.destination,
        "departure_date": schedule.departure_date,
        "class": schedule.ship_class,
        "price": schedule.ticket_price
    } for schedule in schedules])
