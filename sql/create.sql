CREATE TABLE "sej_roles" (
    "id"                                                                SERIAL8 NOT NULL,
    "name"                                                              TEXT NOT NULL,
    "description"                                                       TEXT NULL,
    CONSTRAINT "pk_sej_roles" PRIMARY KEY ("id")
);

CREATE TABLE "sej_role_parents" (
    "id_role_child"                                                             INT8 NOT NULL,
    "id_role_parent"                                                            INT8 NOT NULL,
    CONSTRAINT "pk_sej_role_parents" PRIMARY KEY ("id_role_child", "id_role_parent"),
    CONSTRAINT "fk_sej_role_parents_child" FOREIGN KEY ("id_role_child") REFERENCES "sej_roles" ("id") ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT "fk_sej_role_parents_parent" FOREIGN KEY ("id_role_parent") REFERENCES "sej_roles" ("id") ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE "sej_users" (
    "id"                                                                SERIAL8 NOT NULL,
    "username"                                                          TEXT NOT NULL,
    "email"                                                             TEXT NULL,
    "clearpassword"                                                     TEXT NULL,
    "passwd"                                                            TEXT NULL,
    "salt"                                                              TEXT NULL,
    "recoverycode"                                                      TEXT NULL,
    "recoveryexpiration"                                                TIMESTAMP WITH TIME ZONE NULL,
    "lockout"                                                           INT4 NOT NULL DEFAULT 1,
    "dtcrea"                                                            TIMESTAMP WITH TIME ZONE NULL,
    "dtupdate"                                                          TIMESTAMP WITH TIME ZONE NULL,
    "logins"                                                            INT8 NOT NULL DEFAULT 0,
    "lastlogin"                                                         TIMESTAMP WITH TIME ZONE NULL,
    "lastactivity"                                                      TIMESTAMP WITH TIME ZONE NULL,
    "lastname"                                                          TEXT NULL,
    "firstname"                                                         TEXT NULL,
    "sexe"                                                              INT8 NULL,
    "birthday"                                                          DATE NULL,
    "mobile"                                                            TEXT NULL,
    "phone"                                                             TEXT NULL,
    "streetnum"                                                         TEXT NULL,
    "street"                                                            TEXT NULL,
    "town"                                                              TEXT NULL,
    "zipcode"                                                           TEXT NULL,
    "country"                                                           TEXT NULL,
    "balance"                                                           FLOAT8 NOT NULL DEFAULT 0,
    "lang"                                                              VARCHAR(20) NULL,
    "cgu"                                                               INT4 NOT NULL DEFAULT 1,
    "cgv"                                                               INT4 NOT NULL DEFAULT 1,
    "newsletter"                                                        INT4 NOT NULL DEFAULT 1,
    CONSTRAINT "pk_sej_users" PRIMARY KEY ("id")
);

CREATE TABLE "sej_users_roles" (
    "id_user"                                                           INT8 NOT NULL,
    "id_role"                                                           INT8 NOT NULL,
    CONSTRAINT "pk_sej_users_roles" PRIMARY KEY ("id_user", "id_role"),
    CONSTRAINT "fk_sej_users_roles_userid" FOREIGN KEY ("id_user") REFERENCES "sej_users" ("id") ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT "fk_sej_users_roles_roleid" FOREIGN KEY ("id_role") REFERENCES "sej_roles" ("id") ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE "sej_user_avatars" (
    "id"                                                                SERIAL8 NOT NULL,
    "id_user"                                                           INT8 NOT NULL,
    "filename"                                                          TEXT NOT NULL,
    "dtcrea"                                                            TIMESTAMP WITH TIME ZONE NULL,
    "dtupdate"                                                          TIMESTAMP WITH TIME ZONE NULL,
    CONSTRAINT "pk_sej_user_avatars" PRIMARY KEY ("id"),
    CONSTRAINT "fk_sej_user_avatars_user" FOREIGN KEY ("id_user") REFERENCES "sej_users" ("id") ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE "sej_user_addresses" (
    "id"                                                                SERIAL8 NOT NULL,
    "id_user"                                                           INT8 NOT NULL,
    "streetnum"                                                         TEXT NULL,
    "street"                                                            TEXT NULL,
    "town"                                                              TEXT NULL,
    "zipcode"                                                           TEXT NULL,
    "country"                                                           TEXT NULL,
    "dtcrea"                                                            TIMESTAMP WITH TIME ZONE NULL,
    "dtupdate"                                                          TIMESTAMP WITH TIME ZONE NULL,
    CONSTRAINT "pk_sej_user_addresses" PRIMARY KEY ("id"),
    CONSTRAINT "fk_sej_user_addresses_user" FOREIGN KEY ("id_user") REFERENCES "sej_users" ("id") ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE "sej_traces" (
    "id"                                                                SERIAL8 NOT NULL,
    "id_user"                                                           INT8 NULL,
    "user_fullname"                                                     TEXT NULL,
    "action_type"                                                       INT8 NOT NULL DEFAULT 0,
    "action_entity"                                                     TEXT NOT NULL,
    "action_id"                                                         INT8 NULL,
    "msg"                                                               TEXT NULL,
    "dtcrea"                                                            TIMESTAMP WITH TIME ZONE NULL,
    CONSTRAINT "pk_sej_traces" PRIMARY KEY ("id"),
    CONSTRAINT "fk_sej_traces_user" FOREIGN KEY ("id_user") REFERENCES "sej_users" ("id") ON UPDATE CASCADE ON DELETE SET NULL
);

CREATE TABLE "sej_staticpages" (
    "id"                                                                SERIAL8 NOT NULL,
    "url"                                                               TEXT NOT NULL,
    "lang"                                                              VARCHAR(20) NULL,
    "title"                                                             TEXT NULL,
    "content1"                                                          TEXT NULL,
    "content2"                                                          TEXT NULL,
    "content3"                                                          TEXT NULL,
    "content4"                                                          TEXT NULL,
    "content5"                                                          TEXT NULL,
    "content6"                                                          TEXT NULL,
    "metakeywords"                                                      TEXT NULL,
    "metadescription"                                                   TEXT NULL,
    "htmltitle"                                                         TEXT NULL,
    "dtcrea"                                                            TIMESTAMP WITH TIME ZONE NULL,
    "dtupdate"                                                          TIMESTAMP WITH TIME ZONE NULL,
    CONSTRAINT "pk_sej_staticpages" PRIMARY KEY ("id")
);

CREATE TABLE "sej_brands" (
    "id"                                                                SERIAL8 NOT NULL,
    "name"                                                              TEXT NOT NULL,
    "title"                                                             TEXT NOT NULL,
    "description"                                                       TEXT NULL,
    "logo"                                                              TEXT NULL,
    "image"                                                             TEXT NULL,
    "banner"                                                            TEXT NULL,
    "frontbanner"                                                       TEXT NULL,
    "metakeywords"                                                      TEXT NULL,
    "metadescription"                                                   TEXT NULL,
    "htmltitle"                                                         TEXT NULL,
    "visibility"                                                        INT4 NOT NULL DEFAULT 1,
    "dtcrea"                                                            TIMESTAMP WITH TIME ZONE NULL,
    "dtupdate"                                                          TIMESTAMP WITH TIME ZONE NULL,
    CONSTRAINT "pk_sej_brands" PRIMARY KEY ("id")
);

CREATE TABLE "sej_brand_i18ns" (
    "id"                                                                SERIAL8 NOT NULL,
    "id_brand"                                                          INT8 NOT NULL,
    "lang"                                                              VARCHAR(20) NOT NULL,
    "title"                                                             TEXT NOT NULL,
    "description"                                                       TEXT NULL,
    "logo"                                                              TEXT NULL,
    "image"                                                             TEXT NULL,
    "banner"                                                            TEXT NULL,
    "frontbanner"                                                       TEXT NULL,
    "metakeywords"                                                      TEXT NULL,
    "metadescription"                                                   TEXT NULL,
    "htmltitle"                                                         TEXT NULL,
    "dtcrea"                                                            TIMESTAMP WITH TIME ZONE NULL,
    "dtupdate"                                                          TIMESTAMP WITH TIME ZONE NULL,
    CONSTRAINT "pk_sej_brand_i18ns" PRIMARY KEY ("id"),
    CONSTRAINT "fk_sej_brand_i18ns_brand" FOREIGN KEY ("id_brand") REFERENCES "sej_brands" ("id") ON UPDATE CASCADE ON DELETE CASCADE
);


CREATE TABLE "sej_coltypes" (
    "id"                                                                SERIAL8 NOT NULL,
    "name"                                                              TEXT NOT NULL,
    "title"                                                             TEXT NOT NULL,
    "description"                                                       TEXT NULL,
    "logo"                                                              TEXT NULL,
    "image"                                                             TEXT NULL,
    "banner"                                                            TEXT NULL,
    "metakeywords"                                                      TEXT NULL,
    "metadescription"                                                   TEXT NULL,
    "htmltitle"                                                         TEXT NULL,
    "visibility"                                                        INT4 NOT NULL DEFAULT 1,
    "dtcrea"                                                            TIMESTAMP WITH TIME ZONE NULL,
    "dtupdate"                                                          TIMESTAMP WITH TIME ZONE NULL,
    CONSTRAINT "pk_sej_coltypes" PRIMARY KEY ("id")
);

CREATE TABLE "sej_coltype_i18ns" (
    "id"                                                                SERIAL8 NOT NULL,
    "id_type"                                                           INT8 NOT NULL,
    "lang"                                                              VARCHAR(20) NOT NULL,
    "title"                                                             TEXT NOT NULL,
    "description"                                                       TEXT NULL,
    "logo"                                                              TEXT NULL,
    "image"                                                             TEXT NULL,
    "banner"                                                            TEXT NULL,
    "metakeywords"                                                      TEXT NULL,
    "metadescription"                                                   TEXT NULL,
    "htmltitle"                                                         TEXT NULL,
    "dtcrea"                                                            TIMESTAMP WITH TIME ZONE NULL,
    "dtupdate"                                                          TIMESTAMP WITH TIME ZONE NULL,
    CONSTRAINT "pk_sej_coltype_i18ns" PRIMARY KEY ("id"),
    CONSTRAINT "fk_sej_coltype_i18ns_type" FOREIGN KEY ("id_type") REFERENCES "sej_coltypes" ("id") ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE "sej_colgroups" (
    "id"                                                                SERIAL8 NOT NULL,
    "name"                                                              TEXT NOT NULL,
    "title"                                                             TEXT NOT NULL,
    "description"                                                       TEXT NULL,
    "logo"                                                              TEXT NULL,
    "image"                                                             TEXT NULL,
    "banner"                                                            TEXT NULL,
    "metakeywords"                                                      TEXT NULL,
    "metadescription"                                                   TEXT NULL,
    "htmltitle"                                                         TEXT NULL,
    "visibility"                                                        INT4 NOT NULL DEFAULT 1,
    "dtcrea"                                                            TIMESTAMP WITH TIME ZONE NULL,
    "dtupdate"                                                          TIMESTAMP WITH TIME ZONE NULL,
    CONSTRAINT "pk_sej_colgroups" PRIMARY KEY ("id")
);

CREATE TABLE "sej_colgroup_i18ns" (
    "id"                                                                SERIAL8 NOT NULL,
    "id_group"                                                          INT8 NOT NULL,
    "lang"                                                              VARCHAR(20) NOT NULL,
    "title"                                                             TEXT NOT NULL,
    "description"                                                       TEXT NULL,
    "logo"                                                              TEXT NULL,
    "image"                                                             TEXT NULL,
    "banner"                                                            TEXT NULL,
    "metakeywords"                                                      TEXT NULL,
    "metadescription"                                                   TEXT NULL,
    "htmltitle"                                                         TEXT NULL,
    "dtcrea"                                                            TIMESTAMP WITH TIME ZONE NULL,
    "dtupdate"                                                          TIMESTAMP WITH TIME ZONE NULL,
    CONSTRAINT "pk_sej_colgroup_i18ns" PRIMARY KEY ("id"),
    CONSTRAINT "fk_sej_colgroup_i18ns_group" FOREIGN KEY ("id_group") REFERENCES "sej_colgroups" ("id") ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE "sej_colweeklys" (
    "id"                                                                SERIAL8 NOT NULL,
    "name"                                                              TEXT NOT NULL,
    "title"                                                             TEXT NOT NULL,
    "description"                                                       TEXT NULL,
    "metakeywords"                                                      TEXT NULL,
    "metadescription"                                                   TEXT NULL,
    "htmltitle"                                                         TEXT NULL,
    "dtstart"                                                           TIMESTAMP WITH TIME ZONE NOT NULL,
    "dtend"                                                             TIMESTAMP WITH TIME ZONE NOT NULL,
    "visibility"                                                        INT4 NOT NULL DEFAULT 1,
    "dtcrea"                                                            TIMESTAMP WITH TIME ZONE NULL,
    "dtupdate"                                                          TIMESTAMP WITH TIME ZONE NULL,
    CONSTRAINT "pk_sej_colweeklys" PRIMARY KEY ("id")
);

CREATE TABLE "sej_colweekly_i18ns" (
    "id"                                                                SERIAL8 NOT NULL,
    "id_weekly"                                                         INT8 NOT NULL,
    "lang"                                                              VARCHAR(20) NOT NULL,
    "title"                                                             TEXT NOT NULL,
    "description"                                                       TEXT NULL,
    "metakeywords"                                                      TEXT NULL,
    "metadescription"                                                   TEXT NULL,
    "htmltitle"                                                         TEXT NULL,
    "dtcrea"                                                            TIMESTAMP WITH TIME ZONE NULL,
    "dtupdate"                                                          TIMESTAMP WITH TIME ZONE NULL,
    CONSTRAINT "pk_sej_colweekly_i18ns" PRIMARY KEY ("id"),
    CONSTRAINT "fk_sej_colweekly_i18ns_weekly" FOREIGN KEY ("id_weekly") REFERENCES "sej_colweeklys" ("id") ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE "sej_prodgroups" (
    "id"                                                                SERIAL8 NOT NULL,
    "id_brand"                                                          INT8 NOT NULL,
    "id_type"                                                           INT8 NOT NULL,
    "id_group"                                                          INT8 NOT NULL,
    "id_weekly"                                                         INT8 NOT NULL,
    "name"                                                              TEXT NOT NULL,
    "title"                                                             TEXT NOT NULL,
    "description"                                                       TEXT NULL,
    "logo"                                                              TEXT NULL,
    "image"                                                             TEXT NULL,
    "weight"                                                            INT8 NOT NULL DEFAULT 0,
    "price"                                                             FLOAT8 NOT NULL DEFAULT 0,
    "quantity"                                                          INT8 NOT NULL DEFAULT 0,
    "initprice"                                                         FLOAT8 NOT NULL DEFAULT 0,
    "initquantity"                                                      INT8 NOT NULL DEFAULT 0,
    "maxreduction"                                                      FLOAT4 NOT NULL DEFAULT 0,
    "metakeywords"                                                      TEXT NULL,
    "metadescription"                                                   TEXT NULL,
    "htmltitle"                                                         TEXT NULL,
    "visibility"                                                        INT4 NOT NULL DEFAULT 1,
    "dtcrea"                                                            TIMESTAMP WITH TIME ZONE NULL,
    "dtupdate"                                                          TIMESTAMP WITH TIME ZONE NULL,
    CONSTRAINT "pk_sej_prodgroups" PRIMARY KEY ("id"),
    CONSTRAINT "fk_sej_prodgroups_brand" FOREIGN KEY ("id_brand") REFERENCES "sej_brands" ("id") ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT "fk_sej_prodgroups_type" FOREIGN KEY ("id_type") REFERENCES "sej_coltypes" ("id") ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT "fk_sej_prodgroups_group" FOREIGN KEY ("id_group") REFERENCES "sej_colgroups" ("id") ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT "fk_sej_prodgroups_weekly" FOREIGN KEY ("id_weekly") REFERENCES "sej_colweeklys" ("id") ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE "sej_prodgroup_i18ns" (
    "id"                                                                SERIAL8 NOT NULL,
    "id_prodgroup"                                                      INT8 NOT NULL,
    "lang"                                                              VARCHAR(20) NOT NULL,
    "title"                                                             TEXT NOT NULL,
    "description"                                                       TEXT NULL,
    "metakeywords"                                                      TEXT NULL,
    "metadescription"                                                   TEXT NULL,
    "htmltitle"                                                         TEXT NULL,
    "dtcrea"                                                            TIMESTAMP WITH TIME ZONE NULL,
    "dtupdate"                                                          TIMESTAMP WITH TIME ZONE NULL,
    CONSTRAINT "pk_sej_prodgroup_i18ns" PRIMARY KEY ("id"),
    CONSTRAINT "fk_sej_prodgroup_i18ns_prodgroup" FOREIGN KEY ("id_prodgroup") REFERENCES "sej_prodgroups" ("id") ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE "sej_prodgroup_images" (
    "id"                                                                SERIAL8 NOT NULL,
    "id_prodgroup"                                                      INT8 NOT NULL,
    "filename"                                                          TEXT NOT NULL,
    "dtcrea"                                                            TIMESTAMP WITH TIME ZONE NULL,
    "dtupdate"                                                          TIMESTAMP WITH TIME ZONE NULL,
    CONSTRAINT "pk_sej_prodgroup_images" PRIMARY KEY ("id"),
    CONSTRAINT "fk_sej_prodgroup_images_prodgroup" FOREIGN KEY ("id_prodgroup") REFERENCES "sej_prodgroups" ("id") ON UPDATE CASCADE ON DELETE SET NULL
);

CREATE TABLE "sej_products" (
    "id"                                                                SERIAL8 NOT NULL,
    "id_prodgroup"                                                      INT8 NOT NULL,
    "variants"                                                          TEXT NOT NULL,
    "quantity"                                                          INT8 NOT NULL DEFAULT 0,
    "dtcrea"                                                            TIMESTAMP WITH TIME ZONE NULL,
    "dtupdate"                                                          TIMESTAMP WITH TIME ZONE NULL,
    CONSTRAINT "pk_sej_products" PRIMARY KEY ("id"),
    CONSTRAINT "fk_sej_products_prodgroup" FOREIGN KEY ("id_prodgroup") REFERENCES "sej_prodgroups" ("id") ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE "sej_product_i18ns" (
    "id"                                                                SERIAL8 NOT NULL,
    "id_product"                                                         INT8 NOT NULL,
    "lang"                                                              VARCHAR(20) NOT NULL,
    "variants"                                                          TEXT NOT NULL,
    "dtcrea"                                                            TIMESTAMP WITH TIME ZONE NULL,
    "dtupdate"                                                          TIMESTAMP WITH TIME ZONE NULL,
    CONSTRAINT "pk_sej_product_i18ns" PRIMARY KEY ("id"),
    CONSTRAINT "fk_sej_product_i18ns_id_product" FOREIGN KEY ("id_product") REFERENCES "sej_products" ("id") ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE "sej_discounts" (
    "id"                                                                SERIAL8 NOT NULL,
    "id_prodgroup"                                                      INT8 NOT NULL,
    "title"                                                             TEXT NOT NULL,
    "conditiontype"                                                     INT4 NOT NULL DEFAULT 0,
    "condition1"                                                        TEXT NULL,
    "condition2"                                                        TEXT NULL,
    "discount"                                                          FLOAT8 NOT NULL DEFAULT 0,
    "active"                                                            INT4 NOT NULL DEFAULT 0,
    "dtcrea"                                                            TIMESTAMP WITH TIME ZONE NULL,
    "dtupdate"                                                          TIMESTAMP WITH TIME ZONE NULL,
    CONSTRAINT "pk_sej_discounts" PRIMARY KEY ("id"),
    CONSTRAINT "fk_sej_discounts_prodgroup" FOREIGN KEY ("id_prodgroup") REFERENCES "sej_prodgroups" ("id") ON UPDATE CASCADE ON DELETE SET NULL
);

CREATE TABLE "sej_discount_i18ns" (
    "id"                                                                SERIAL8 NOT NULL,
    "id_discount"                                                       INT8 NOT NULL,
    "lang"                                                              VARCHAR(20) NOT NULL,
    "title"                                                             TEXT NOT NULL,
    "dtcrea"                                                            TIMESTAMP WITH TIME ZONE NULL,
    "dtupdate"                                                          TIMESTAMP WITH TIME ZONE NULL,
    CONSTRAINT "pk_sej_discount_i18ns" PRIMARY KEY ("id"),
    CONSTRAINT "fk_sej_discount_i18ns_discount" FOREIGN KEY ("id_discount") REFERENCES "sej_discounts" ("id") ON UPDATE CASCADE ON DELETE SET NULL
);

