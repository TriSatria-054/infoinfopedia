-- Database: uaslabinfoinfopedia

-- DROP TABLE IF EXISTS article_comment;
-- DROP TABLE IF EXISTS article_like;
-- DROP TABLE IF EXISTS article;
-- DROP TABLE IF EXISTS userinfo;

-- Table structure for table `article`
CREATE TABLE article (
  id SERIAL PRIMARY KEY,
  user_email varchar(100) NOT NULL,
  username varchar(100) NOT NULL,
  title text NOT NULL,
  content text NOT NULL,
  date date,
  gambar varchar(100) NOT NULL,
  created_at timestamp DEFAULT current_timestamp::timestamp(0) without time zone,
  article_like int DEFAULT 0,
  article_dislike int DEFAULT 0,
  article_comment int DEFAULT 0
);

-- Table structure for table `article_comment`
CREATE TABLE article_comment (
  id SERIAL PRIMARY KEY,
  article_id int NOT NULL,
  user_id int NOT NULL,
  content varchar(9999) NOT NULL,
  created_at timestamp DEFAULT current_timestamp::timestamp(0) without time zone
);

-- Table structure for table `article_like`
CREATE TABLE article_like (
  id SERIAL PRIMARY KEY,
  article_id int NOT NULL,
  user_id int NOT NULL,
  action text NOT NULL CHECK (action IN ('like', 'dislike'))
);

-- Table structure for table `userinfo`
CREATE TABLE userinfo (
  id SERIAL PRIMARY KEY,
  username varchar(100) NOT NULL,
  user_email varchar(100) NOT NULL,
  password varchar(255),
  profile_picture varchar(100) NOT NULL,
  created_at timestamp DEFAULT current_timestamp::timestamp(0) without time zone
);

select * from article
select * from article_comment
select * from article_like
select * from userinfo

