import mysql.connector
import random

# Establish database connection
connection = mysql.connector.connect(user='root', password='', host='localhost', database='project')
cursor = connection.cursor()

def fetch_data(cursor, table_name):
    # Function to fetch all data from a table
    cursor.execute(f'SELECT * FROM {table_name}')
    return cursor.fetchall()

def delete_all_records(cursor, table_name):
    # Function to delete all records from a table
    cursor.execute(f"DELETE FROM {table_name}")
    connection.commit()

def generate_timetable(cursor, connection, days, timeslots, subjects, classrooms):
    # Function to generate timetables based on existing allotments
    for day in days:
        for timeslot in timeslots:
            for classroom in classrooms:
                # Selecting allotments for the given day, timeslot, and classroom
                cursor.execute(f"SELECT * FROM allotment WHERE Allocated_1 IS NOT NULL AND Allocated_2 IS NOT NULL AND Allocated_3 IS NOT NULL")
                allotments = cursor.fetchall()

                if not allotments:
                    # If no allotments are found, skip to the next iteration
                    print(f"No allotments found for day {day}, timeslot {timeslot}, and classroom {classroom[0]}")
                    continue

                # Randomly selecting an allotment
                allotment = random.choice(allotments)
                subject_code = allotment[0]
                teacher_id = random.choice([allotment[2], allotment[3], allotment[4]])

                # Inserting the timetable entry for the selected allotment
                cursor.execute(
                    f"INSERT INTO timetable (timetable_id, Days, time_slot, subject_code, teacher_id, class_id) VALUES (NULL, '{day}', '{timeslot}', '{subject_code}', '{teacher_id}', '{classroom[0]}')")
                connection.commit()

def main():
    try:
        # Fetch data
        subjects = fetch_data(cursor, 'subjects')
        classrooms = fetch_data(cursor, 'classrooms')

        # Delete existing records
        delete_all_records(cursor, 'timetable')

        # Generate timetables
        days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday']
        timeslots = ['09:00:00', '10:00:00', '11:00:00', '14:00:00', '15:00:00', '16:00:00']
        generate_timetable(cursor, connection, days, timeslots, subjects, classrooms)

    finally:
        # Close cursor and connection
        cursor.close()
        connection.close()

if __name__ == "__main__":
    # Execute the main function
    main()
