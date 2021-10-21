# **Hiring - Lobby Wars**

## **Description**

We are in the era of "lawsuits", everyone wants to go to court with their lawyer Saul and try to get a lot of dollars as if they were raining over Manhattan.

The laws have changed much lately and governments have been digitized. That's when Signaturit comes into play.

The city council through the use of Signaturit maintains a registry of legal signatures of each party involved in the contracts that are made.

During a trial, justice only verifies the signatures of the parties involved in the contract to decide who wins. For that, they assign points to the different signatures depending on the role of who signed.

For example, if the plaintiff has a contract that is signed by a notary he gets 2 points, if the defendant has in the contract the signature of only a validator he gets only 1 point, so the plaintiff party wins the trial.

> Keep in mind that when a King signs, the signatures of the validators on his part have no value.

Our current solution provides two functionalities and their main goals are:

1. Identify the winner of a trial `KNV vs NVV` ⇒ `KNV wins`
2. Identify what signature is needed in order to win. `KV# vs NVVVN` ⇒ `K`

### **Roles**

- King (K): 5 points.
- Notary (N): 2 points.
- Validator (V): 1 point.

### Set up project

1. Run docker containers`docker-compose up -d`
2. Install dependencies`docker-compose run --rm php-signaturit composer install`

### Identify the winner of a trial

1. Execute a GET request passing both contracts as a string in the query param `contract`

```bash
curl --location --request GET 'http://localhost:8080?contract=KNV%20vs%20NVV'
```

2. Response:

```json
{"contract":"KNV"}
```

### Identify signature to win

1. Execute a GET request passing both contracts as a string in the query param `contract`. In this case, the first contract can have the character `#` as a wildcard.

```bash
curl --location --request GET 'http://localhost:8080?contract=K%23%20vs%20NVVVNV'
```

2. Response:
d
```bash
"K"
```

> Use URL encoded character to use `# (%23)`

## Exercise 1

Our support team has reported some incidents on trials and they are causing a lot of wrong judgments. In some cases (see the example below), the trial's winner is incorrect and they do not know the reason yet. They have asked us to help, identify the root cause and fix it.

Executed the following request:

```bash
curl --location --request GET 'http://localhost:8080?contract=KVNVVV%20vs%20NVNVNN'
```

Actual behaviour:

```json
{"contract":"KVNVVV"}
```

Expected behaviour:

```json
{"contract":"NVNVNN"}
```

## Exercise 2

There have been few changes on our law in the last weeks and we are now in a hurry of implementing these modifications.

On of the new requirements has to be implemented and it is defined as:

`Any contract that contains a new role Z it automatically wins the trail`

An example of the request would be:

```bash
curl --location --request GET 'http://localhost:8080?contract=ZN%20vs%20KKKKKKK'
```

Actual:

```json
{"contract":"ZN"}
```
