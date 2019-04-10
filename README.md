# Oingo-Web-Application-Design

You are hired by a startup company to help build the database backend for a new mobile app named oingo that allows users
to share useful information via their mobile devices based on social, geographic, temporal, and keyword constraints. Of
course, oingo borrows ideas from many existing applications such as Foursquare, Twitter, Facebook, etc. The main idea
in oingo is that users can publish information in the form of short notes, and then link these notes to certain locations and
certain times. Other users can then receive these notes based on their own location, the current time, and based on what
type of messages they want to receive. The startup believes that this may become a popular application as it can be useful
in many scenarios. For example:
• Suppose you discover a nice Thai restaurant (by finding it on the web or by walking by it) that you want to try out
some time for lunch. To make sure that you do not forget the restaurant, you want the app to send you a note if you
are ever within 300 yards of the restaurant during lunch time.
• Or maybe you see a store that you think one of your friends might really like. You could then add a note about this
store, such that your friend (or maybe everybody) sees the note if they come within a certain distance of this place.
• Suppose the local historical society wants to leave a note that tells tourists about an interesting place (a building or a
monument), so that tourists within 100 yards who use the app can see the information.
• A store or restaurant might want to show information about special deals to potential customers nearby during times
when such deals are available (e.g., during Happy Hour for a bar).
• Or you might sit somewhere and be interested in meeting other people, either your friends who are nearby or people
that you do not know yet.

In the backend, you will have to design the relational database that stores all the
information about users, friendships between users, notes published by users, and filters that users have for what kind of
notes they want to receive at different times and in different situations (i.e., states and locations). In the frontend, you have to design a web-accessible interface for this system
