ALTER TABLE users ADD uuid char(36);
ALTER TABLE users ADD UNIQUE (uuid);
ALTER TABLE users ADD token char(40);
ALTER TABLE users ADD secret char(40);
