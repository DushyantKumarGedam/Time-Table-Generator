import mysql.connector
from prettytable import PrettyTable

def fetch_timetable_for_class(cursor, class_id):
    cursor.execute(f"SELECT timetable.*, subjects.subject_name FROM timetable JOIN subjects ON timetable.subject_code = subjects.subject_code WHERE timetable.class_id = '{class_id}' ORDER BY timetable.time_slot, timetable.Days")
    return cursor.fetchall()

def create_timetable_grid(timetable_data):
    timetable_grid = {}

    for entry in timetable_data:
        time_slot = entry[2]
        day = entry[1]
        subject = entry[6]  # Index 6 corresponds to the subject_name column

        if time_slot not in timetable_grid:
            timetable_grid[time_slot] = {}

        timetable_grid[time_slot][day] = subject

    return timetable_grid

def print_timetable(timetable_grid, class_id):
    days_of_week = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday']

    timetable_table = PrettyTable()
    timetable_table.field_names = ['Time'] + days_of_week

    for time_slot, day_data in sorted(timetable_grid.items()):
        row_data = [time_slot]

        for day in days_of_week:
            subject = day_data.get(day, '')
            row_data.append(subject)

        timetable_table.add_row(row_data)

    print(f"Timetable for Class ID: {class_id}")
    print(timetable_table)

def main():
    try:
        connection = mysql.connector.connect(user='root', password='', host='localhost', database='project')
        cursor = connection.cursor()

        class_id = "C108"  # Prompt user for class_id
        timetable_data = fetch_timetable_for_class(cursor, class_id)

        if not timetable_data:
            print(f"No timetable found for Class ID: {class_id}")
        else:
            timetable_grid = create_timetable_grid(timetable_data)
            print_timetable(timetable_grid, class_id)

    finally:
        cursor.close()
        connection.close()

if __name__ == "__main__":
    main()
