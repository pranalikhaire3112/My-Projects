CREATE DATABASE artist_db;
USE artist_db;

-- Q1. Display all artist
SELECT * FROM artist;

-- Q2. Display only artist full name and nationality
SELECT full_name, nationality
FROM artist;

-- Q3. Count total number of artists
SELECT COUNT(*) AS total_artist
FROM artist;

-- Q4. Display artist from France
SELECT full_name
FROM artist
WHERE nationality = 'French';

-- Q5. Display artist born after 1850
SELECT full_name, birth
FROM artist
WHERE birth > 1850;

-- Q6. Display artists ordered by birth year
SELECT full_name, birth
FROM artist
ORDER BY birth;

-- Q7. Find the oldest artist
SELECT full_name, birth
FROM artist
ORDER BY birth
LIMIT 1;

-- Q8. Find artist whose middle name is missing
SELECT full_name
FROM artist
WHERE middle_names is NULL;

-- Q9. Display distinct nationalities
SELECT DISTINCT nationality
FROM artist;

-- Q10. Count artist who are still alive
SELECT COUNT(*) AS alive_artist
FROM artist
WHERE death IS NULL;

-- Q11. Count artist by art style
SELECT style, COUNT(*) AS total_artist
FROM artist
GROUP BY style;

-- Q12. Find nationality with highest number of artists
SELECT nationality, COUNT(*) AS artist_count
FROM artist
GROUP BY nationality
ORDER BY artist_count DESC
LIMIT 1;

-- Q13. Find most common art style
SELECT style, COUNT(*) AS total
FROM artist
GROUP BY style
ORDER BY total DESC
LIMIT 1;

-- Q14. Nationalities having more than 5 artist
SELECT nationality, COUNT(*) AS total_count
FROM artist
GROUP BY nationality
HAVING COUNT(*) > 5;

-- Q15. Rank artist by birth year
SELECT full_name, birth,
	   RANK() OVER (ORDER BY birth) AS birth_rank
FROM artist;

-- Q16. Artist born between 1800 and 1900
SELECT full_name, birth
FROM artist
WHERE birth BETWEEN 1800 and 1900;

-- Q17. Rank artists by lifespan with nationality
SELECT full_name, nationality,
		(death - birth) AS lifespan,
        RANK() OVER (
			PARTITION BY nationality
            ORDER BY (death - birth) DESC
		) AS rank_in_country
FROM artist
WHERE death IS NOT NULL;

CREATE TABLE artwork(
	artwork_id INT PRIMARY KEY,
    title VARCHAR(200),
    artist_id INT,
    year_created INT,
    price DECIMAL(10,2)
);

-- Q18. Show artwork with artist name
SELECT a.full_name, w.title, w.year_created
FROM artist a
INNER JOIN artwork w
ON a.artist_id = w.artist_id;

-- Q19. Artists even if they have no artwork
SELECT a.full_name, w.title
FROM artist a
LEFT JOIN artwork w
ON a.artist_id = w.artist_id;

-- Q20. Find artist with NO artworks
SELECT a.full_name
FROM artist a
LEFT JOIN artwork w
ON a.artist_id = w.artist_id
WHERE w.artwork_id IS NULL;

-- Q21. All networks even if artist missing
SELECT a.full_name, w.title
FROM artist a
RIGHT JOIN artwork w
ON a.artist_id = w.artist_id;

-- Q22. Artist with artwork priced above average
SELECT DISTINCT a.full_name
FROM artist a
JOIN artwork w
ON a.artist_id = w.artist_id
WHERE w.price >
		(SELECT AVG(price) FROM artwork);

-- Q23. Assign row numbers to artist
SELECT
	full_name,
    ROW_NUMBER() OVER () AS row_num
FROM artist;

-- Q24. Categorize artists as Old or Young based on birth year
SELECT
    full_name,
    birth,
    CASE
        WHEN birth < 1970 THEN 'Old Artist'
        ELSE 'Young Artist'
    END AS artist_category
FROM artist;

-- Q25. Classify artist by era
SELECT
    full_name,
    birth,
    CASE
        WHEN birth < 1900 THEN 'Classical'
        WHEN birth BETWEEN 1900 AND 1950 THEN 'Modern'
        ELSE 'Contemporary'
    END AS artist_era
FROM artist;

-- Q26. Find artists with maximum birth year
SELECT full_name, birth
FROM artist
WHERE birth = (
    SELECT MAX(birth) FROM artist
);

-- Q27. Count artists grouped by life status
SELECT
    CASE
        WHEN death IS NULL THEN 'Alive'
        ELSE 'Deceased'
    END AS life_status,
    COUNT(*) AS total_artists
FROM artist
GROUP BY life_status;

-- Q28. Artists who lived more than 70 years
SELECT
    full_name,
    birth,
    death,
    (death - birth) AS lifespan
FROM artist
WHERE death IS NOT NULL
  AND (death - birth) > 70;
  
-- Q29. Find top 5 oldest artists
SELECT
    full_name,
    birth
FROM artist
WHERE birth IS NOT NULL
ORDER BY birth ASC
LIMIT 5; 

-- Q30. Nationalities with no living artists
SELECT nationality
FROM artist
GROUP BY nationality
HAVING SUM(
    CASE
        WHEN death IS NULL THEN 1
        ELSE 0
    END
) = 0;


 






