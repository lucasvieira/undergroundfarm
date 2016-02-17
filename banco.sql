CREATE TABLE banners (
        id int(11) NOT NULL AUTO_INCREMENT,
        title varchar(128) NOT NULL,
        img varchar(255) NOT NULL,
        img_mobile varchar(255),
        PRIMARY KEY (id)
);
