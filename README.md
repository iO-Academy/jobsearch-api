# JobSearch RESTful API

<details>
<summary>Run the API locally</summary>

<p></p>
<p>
Clone this repo into your docker `html` folder:

```bash
git clone git@github.com:iO-Academy/jobsearch-api.git
```

Once cloned, you must install the vendor code by running:

```bash
composer install
```

To run the application locally:
```bash
composer start
```

That's it! Now go build something cool.
</p>
</details>

## API documentation

This API only supports GET requests.

### Return all jobs, optionally searched or filtered by URL parameters

* **URL**

  /jobs

* **Method:**

  `GET`

* **URL Params**

   **Required:**

   There are no required URL Params, this URL will return all jobs if no params are passed

   **Optional:**

    `search=[alphanumeric]` - a search term which will search `job_title` and `company`. If no skill filter is provided, it will also search for jobs with skills like your search term.

    `skill=[integer]` - the ID of a skill. When used alone, this will return all jobs with this skill, when combined with search, it will return jobs with this skill that match the search term in the `job_title` or `company` fields.

    `type=[alphabetical]` - filter jobs by the job type, the available values are: `Part time`, `Full time`, `Contract`. Note: not all jobs have a type

* **Success Response:**

    * **Code:** 200 <br />
      **Content:** <br />

  ```json
  [
      {
          "id": "300",
          "job_title": "Junior software engineer",
          "company": "Demivee",
          "logo": "https://dummyimage.com/250/000000/89e632&text=Logo",
          "salary": "127228",
          "type": "Full time",
          "skills": [
              {"id": "5","skill": "Ruby"}, {"id": "8","skill": "Python"}
          ]
      },
      {
          "id": "439",
          "job_title": "Junior software engineer",
          "company": "Yata",
          "logo": "https://dummyimage.com/250/000000/d91c4e&text=Logo",
          "salary": "129291",
          "type": null,
          "skills": [{"id": "2","skill": "JavaScript"}]
      }
  ]
  ```

* **Error Response:**

    * **Code:** 500 SERVER ERROR <br />
      **Content:** `{"message": "Unexpected error while encoding JSON data"}`

### Returns the 10 most recent job posts

* **URL**

  /jobs/recent

* **Method:**

  `GET`

* **URL Params**

  **Required:**

  There are no required URL Params

  **Optional:**

  There are no optional URL Params

* **Success Response:**

  * **Code:** 200 <br />
    **Content:** <br />

  ```json
  [
      {
          "id": "300",
          "job_title": "Junior software engineer",
          "company": "Demivee",
          "logo": "https://dummyimage.com/250/000000/89e632&text=Logo",
          "salary": "127228",
          "type": "Full time",
          "skills": [
              {"id": "5","skill": "Ruby"}, {"id": "8","skill": "Python"}
          ]
      },
      {
          "id": "439",
          "job_title": "Junior software engineer",
          "company": "Yata",
          "logo": "https://dummyimage.com/250/000000/d91c4e&text=Logo",
          "salary": "129291",
          "type": null,
          "skills": [{"id": "2","skill": "JavaScript"}]
      }
  ]
  ```

* **Error Response:**

    * **Code:** 500 SERVER ERROR <br />
      **Content:** `{"message": "Unexpected error while encoding JSON data"}`


### Returns all information about a single job

* **URL**

  /jobs/{id}

* **Method:**

  `GET`

* **URL Params**

  **Required:**

  There are no required URL Params

  **Optional:**

  There are no optional URL Params

* **Success Response:**

    * **Code:** 200 <br />
      **Content:** <br />

  ```json
  {
      "id": "300",
      "job_title": "Junior software engineer",
      "company": "Demivee",
      "logo": "https://dummyimage.com/250/000000/89e632&text=Logo",
      "job_description": "Vestibulum ac est lacinia nisi venenatis tristique. Fusce congue, diam id ornare imperdiet, sapien urna pretium nisl, ut volutpat sapien arcu sed augue. Aliquam erat volutpat.\n\nIn congue. Etiam justo. Etiam pretium iaculis justo.\n\nIn hac habitasse platea dictumst. Etiam faucibus cursus urna. Ut tellus.\n\nNulla ut erat id mauris vulputate elementum. Nullam varius. Nulla facilisi.\n\nCras non velit nec nisi vulputate nonummy. Maecenas tincidunt lacus at velit. Vivamus vel nulla eget eros elementum pellentesque.\n\nQuisque porta volutpat erat. Quisque erat eros, viverra eget, congue eget, semper rutrum, nulla. Nunc purus.\n\nPhasellus in felis. Donec semper sapien a libero. Nam dui.\n\nProin leo odio, porttitor id, consequat in, consequat ut, nulla. Sed accumsan felis. Ut at dolor quis odio consequat varius.",
      "salary": "127228",
      "type": "Full time",
      "skills": [
          {"id": "5","skill": "Ruby"}, {"id": "8","skill": "Python"}
      ]
  }
  ```

* **Error Response:**

    * **Code:** 500 SERVER ERROR <br />
      **Content:** `{"message": "Unexpected error while encoding JSON data"}`

    OR

    * **Code:** 400 CLIENT ERROR <br />
      **Content:** `{"message": "Invalid job ID"}`    


### Returns 3 similar jobs to the provided job ID

* **URL**

  /jobs/{id}/similar

* **Method:**

  `GET`

* **URL Params**

  **Required:**

  There are no required URL Params

  **Optional:**

  There are no optional URL Params

* **Success Response:**

    * **Code:** 200 <br />
      **Content:** <br />

  ```json
  [
      {
          "id": "300",
          "job_title": "Junior software engineer",
          "company": "Demivee",
          "logo": "https://dummyimage.com/250/000000/89e632&text=Logo",
          "salary": "127228",
          "type": "Full time",
          "skills": [
              {"id": "5","skill": "Ruby"}, {"id": "8","skill": "Python"}
          ]
      },
      {
          "id": "439",
          "job_title": "Junior software engineer",
          "company": "Yata",
          "logo": "https://dummyimage.com/250/000000/d91c4e&text=Logo",
          "salary": "129291",
          "type": null,
          "skills": [{"id": "2","skill": "JavaScript"}]
      },
      {
          "id": "558",
          "job_title": "Junior web developer",
          "company": "Vinte",
          "logo": "https://dummyimage.com/250/000000/d91c4e&text=Logo",
          "salary": "20428",
          "type": "Contract",
          "skills": [{"id": "9","skill": "Bash"}]
      }
  ]
  ```

* **Error Response:**

    * **Code:** 500 SERVER ERROR <br />
      **Content:** `{"message": "Unexpected error while encoding JSON data"}`

  OR

    * **Code:** 400 CLIENT ERROR <br />
      **Content:** `{"message": "Invalid job ID"}`   

### Returns all skills and a count of jobs related to that skill

* **URL**

  /skills

* **Method:**

  `GET`

* **URL Params**

  **Required:**

  There are no required URL Params

  **Optional:**

  There are no optional URL Params

* **Success Response:**

    * **Code:** 200 <br />
      **Content:** <br />

  ```json
  [
      {
          "id": "1",
          "skill": "PHP",
          "job_count": "107"
      },
      {
          "id": "2",
          "skill": "JavaScript",
          "job_count": "90"
     }
  ]
  ```

* **Error Response:**

    * **Code:** 500 SERVER ERROR <br />
      **Content:** `{"message": "Unexpected error while encoding JSON data"}`

### Returns all companies that have current job postings

* **URL**

  /companies

* **Method:**

  `GET`

* **URL Params**

  **Required:**

  There are no required URL Params

  **Optional:**

  There are no optional URL Params

* **Success Response:**

    * **Code:** 200 <br />
      **Content:** <br />

  ```json
  [    
      "Abata",
      "Abatz",
      "Agimba",
      "Agivu"
  ]
  ```

* **Error Response:**

    * **Code:** 500 SERVER ERROR <br />
      **Content:** `{"message": "Unexpected error while encoding JSON data"}`

### Returns 5 most recent companies that have posted a job

* **URL**

  /companies

* **Method:**

  `GET`

* **URL Params**

  **Required:**

  There are no required URL Params

  **Optional:**

  There are no optional URL Params

* **Success Response:**

    * **Code:** 200 <br />
      **Content:** <br />

  ```json
  [    
      {
          "company": "Demimbu",
          "logo": "https://dummyimage.com/250/d91c4e/ffffff&text=Logo",
          "last_job_posted": "2021-12-31"
      },
      {
          "company": "Eare",
          "logo": "https://dummyimage.com/250/d91c4e/000000&text=Logo",
          "last_job_posted": "2021-12-31"
      }
  ]
  ```

* **Error Response:**

    * **Code:** 500 SERVER ERROR <br />
      **Content:** `{"message": "Unexpected error while encoding JSON data"}`