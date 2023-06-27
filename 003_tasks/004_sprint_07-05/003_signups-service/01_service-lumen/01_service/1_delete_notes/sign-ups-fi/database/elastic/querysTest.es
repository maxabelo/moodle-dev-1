GET academic-administration.sign-ups-local.inscriptions/_search

GET academic-administration.sign-ups-local.students/_search
{
    "query":{
        "match_all": {}
    }
}

GET academic-administration.sign-ups-local.students/_search?pretty
    {
    "query":{
        "match": {"first_name": "Davor Marcelo"}
    }
}

GET academic-administration.sign-ups-local.enqueue_failed/_search
{
    "query":{
        "match_all": {}
    }
}

GET academic-administration.sign-ups-local.enqueue_dispatch/_search
{
    "query": {
        "match_all": {}
    }
}


GET http://localhost:9200/students/_search?-d
{
    "query": {
        "match_all": {}
    }
}


GET academic-administration.sign-ups-local.jobs/_search
{
    "query":{
        "match_all": {}
    }
}

Por comandos
"curl -X GET "http://localhost:9200/students/_search?pretty"
curl 'localhost:9200/_cat/indices?v'

GET /_cat/health?v

GET /_cat/indices?v

GET /_cat/indices?v