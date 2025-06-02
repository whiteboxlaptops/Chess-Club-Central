I DID NOT CREATE THIS!\
I just made it work again.\
\
\
docker run -d \\\
&nbsp;&nbsp;-p 80:80 \\\
&nbsp;&nbsp;-p 3306:3306 \\\
&nbsp;&nbsp;--name chess-container \\\
&nbsp;&nbsp;-v "path/to/local/storage":/var/lib/mysql \\\
fletcher27/chess-club-central:latest
