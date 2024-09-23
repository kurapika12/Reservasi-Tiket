from flask_sqlalchemy import SQLAlchemy

db = SQLAlchemy()

class ShipSchedule(db.Model):
    __tablename__ = 'ship_schedules'
    id = db.Column(db.Integer, primary_key=True)
    origin = db.Column(db.String(50), nullable=False)
    destination = db.Column(db.String(50), nullable=False)
    departure_date = db.Column(db.String(50), nullable=False)
    ship_class = db.Column(db.String(50), nullable=False)
    ticket_price = db.Column(db.Float, nullable=False)

class Ticket(db.Model):
    __tablename__ = 'tickets'
    id = db.Column(db.Integer, primary_key=True)
    name = db.Column(db.String(100), nullable=False)
    schedule_id = db.Column(db.Integer, db.ForeignKey('ship_schedules.id'), nullable=False)
    schedule = db.relationship('ShipSchedule', backref=db.backref('tickets', lazy=True))
