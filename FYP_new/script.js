window.onload = function(){
    const currentWeek = localStorage.getItem('currentWeek') || 1;
    document.getElementById('weekNumber').innerText = currentWeek;

    //Fetch meeting schedules for the current week
    fetchMeetingsForWeek(currentWeek);
};

function fetchMeetingsForWeek(weekNumber){
    const xhr = new XMLHttpRequest();
    xhr.open('GET', `../server/fetchMeetings.php?week=${weekNumber}`, true);

    xhr.onload = function(){
        if (this.status === 200){
            const meetings = JSON.parse(this.responseText);
            displayMeetings(meetings);
        }
    };
    xhr.send();
}

function displayMeetings(meetings){
    const scheduleContainer = document.getElementById('meetingSchedule');
    scheduleContainer.innerHTML = ''; //Clear previous content

    if (meetings.length === 0){
        scheduleContainer.innerHTML = '<p>No meetings scheduled for this week.</p>';
    }
    else{
        meetings.forEach(meeting => {
            const meetingDiv = document.createElement('div');
            meetingDiv.className = 'meeting';
            meetingDiv.innerHTML = `
                                    <h3>${meeting.title}</h3>
                                    <p>${meeting.date}, ${meeting.time}</p>
                                    <p>Attendees: ${meeting.attendees.join(', ')}</p>
                                    `;
            scheduleContainer.appendChild(meetingDiv);
        });
    }
}