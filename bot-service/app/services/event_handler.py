import time
from facebook_business.api import FacebookAdsApi
from facebook_business.adobjects.serverside.event_request import EventRequest
from facebook_business.adobjects.serverside.event import Event
from db import Session
from sqlalchemy import text


def send_event(invite_code):
    session = Session()
    try:
        pixel_id_query = text(
            "SELECT pixel_id FROM audience WHERE invite_code = :invite_code"
        )
        result = session.execute(
            pixel_id_query, {"invite_code": invite_code}
        ).fetchone()
        pixel_id = result[0]

        pixel_api_query = text("SELECT pixel_api FROM pixel WHERE pixel_id = :pixel_id")
        result = session.execute(pixel_api_query, {"pixel_id": pixel_id}).fetchone()
        pixel_api = result[0]

        site_source_name_query = text(
            "SELECT site_source_name FROM audience WHERE invite_code = :invite_link"
        )
        result = session.execute(
            site_source_name_query, {"invite_link": invite_link}
        ).fetchone()
        site_source_name = result[0]

        placement_query = text(
            "SELECT placement FROM audience WHERE invite_code = :invite_link"
        )
        result = session.execute(
            placement_query, {"invite_link": invite_link}
        ).fetchone()
        placement = result[0]

        FacebookAdsApi.init(access_token=pixel_api)

        #TODO: create event request

        event = Event(
            event_name="Subscribe",
            event_time=int(time.time()),
            event_source_url="http://somewebsite.com",
        )

        event_request = EventRequest(
            events=[event],
            pixel_id=pixel_id,
        )

        event_request.execute()
    except Exception as e:
        raise e
    finally:
        session.close()
