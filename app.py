from gradio_client import Client

client = Client('eduardmihai/chatbot2')
result = client.predict(
    prompt="How can I get a week off?",
    # temperature=0.7,
    # max_new_tokens=100,
    # top_p=0.95,
    # top_k=50,
    # num_beams=4,
    # do_sample=True,
    api_name="/predict")

print(result)

