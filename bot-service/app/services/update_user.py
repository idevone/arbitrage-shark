from db import Session
from services.event_handler import send_event
from sqlalchemy import text


def update_db(user_id, invite_code):
    session = Session()
    try:
        update_query = text(
            """
            UPDATE audience 
            SET user_id = :user_id, status = 'Subscriber' 
            WHERE invite_code = :invite_code
        """
        )
        session.execute(update_query, {"user_id": user_id, "invite_code": invite_code})
        session.commit()
        session.close()
        send_event(invite_code)
    except Exception as e:
        session.rollback()
        raise e
    finally:
        session.close()
